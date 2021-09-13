import React, { Component } from 'react'
import {Link} from 'react-router-dom'
import jQuery from 'jquery'
import {getCookie} from './cookie'
import {urls} from './method'
import ReactPaginate from 'react-paginate'
export default class Affiliatelist extends Component {

  constructor(props) {
        super(props)
        this.state = {
            transactions:[],
            itemsperpage:10,
            pageNumber:0,
            getNoButtons:''
        }
        this.checkEmptyObject = this.checkEmptyObject.bind(this)
  }
  _isMounted=false;
  componentDidMount(){
    this._isMounted =true;
    var title = document.getElementById('title');
    title.innerHTML = `Transactions | Helapoint`;
    const userId = localStorage.getItem('__esMode');
    if(this._isMounted ){
        this.fetchUserTransaction(userId);
    }
  }
  checkEmptyObject =(object)=>{
    return JSON.stringify(object) === JSON.stringify({})
  }
  fetchUserTransaction= userId =>{
    const cookieName = getCookie('_AIOf')
        if(this.checkEmptyObject(cookieName)){
          return false
        }else{
          const token = JSON.parse(cookieName);
          const h = this;
          const {itemsperpage} = this.state
          const newToken = token.token;
          if(token.token !== " " || token.token != null || token.token !== undefined){
            const uri = urls('account/getaffiliate.php')
            const h =this;
            if(this._isMounted){
              jQuery.ajax({
                url: uri,
                method: "POST",
                data: {
                    token: newToken,
                },
                dataType: "html",
                success: function (data) {
                   const Data = JSON.parse(data)
                   const dataLength= Data.data.length
                   h.setState({
                    transactions:Data.data,
                    getNoButtons:Math.ceil(dataLength/itemsperpage)
                   })

                }
              })
            }
          }else{
            return false;
          }
        }
  }
  componentWillUnmount(){
      this._isMounted = false;
  }
  render() {
    const pageVisited = this.state.pageNumber * this.state.itemsperpage;
    const {transactions,itemsperpage,getNoButtons}=this.state
    // const pagecount = Math.ceil(transactions.length/)
    const itemsToDisplay = transactions.slice(pageVisited,pageVisited+ itemsperpage).map(items=>(
        <tr>
            <td>{items.referId}</td>
            <td>{items.firstname}</td>
            <td>{items.lastname}</td>
            <td>{items.amount}</td>
            <td><Link to="#" className="status_btn active_btn">{items.verified==2?'active':'Not active'}</Link></td>   
            <td>{
                items.referee_level == 'super'?'Level 1':items.referee_level=='level 1'?'Level 2':items.referee_level=='level 2'?'Level 3':items.referee_level=='level 3'?'Level 4':''
            }</td>
            <td>{items.date}</td>
        </tr>
    ))
    const setPagerNumber=({selected})=>{
        this.setState({
            pageNumber:selected
        });
    }
    return (
        <div className="col-lg-12">
            <div className="white_card card_height_100 mb_30">
                <div className="white_card_body">
                    <div className="QA_section">
                        <div className="QA_table mb_30">

                            <table className="table lms_table_active3 ">
                                <thead>
                                    <tr>
                                        <th scope="col">Referal Id</th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">account status</th>
                                        <th scope="col">Level</th>
                                        <th scope="col">Date Joined</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        {itemsToDisplay}
                                      </tbody>
                                  </table>
                                  <center>
                                    <ReactPaginate
                                        pageCount={getNoButtons}
                                        previousLabel={"Previous"}
                                        nextLabel={"Next"}
                                        onPageChange={setPagerNumber}
                                        containerClassName={'paginationButtons'}
                                        previousLinkClassName={'previous'}
                                        nextLinkClassName={'nextLinkClassName'}
                                        activeClassName={'activeClassName'}
                                        disabledClassName={'disabledClassName'}
                                    />
                                  </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
  }
}

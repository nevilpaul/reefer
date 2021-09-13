import React, { Component } from 'react'
import {Link} from 'react-router-dom'

import {urls} from './method'
import jQuery from 'jquery'
import {getCookie} from './cookie'

class RecentActivities extends Component {
    constructor(props){
        super(props)
        this.state ={
          recentData :[]
        }
        this.checkEmptyObject = this.checkEmptyObject.bind(this)
      }
      _isMounted=false;
      checkEmptyObject =(object)=>{
        return JSON.stringify(object) === JSON.stringify({})
      }
    
      componentDidMount(){
        this._isMounted=true;
        var title = document.getElementById('title');
        title.innerHTML = `Dashboard | Reefer`;
        const cookieName = getCookie('_AIOf')
        if(this.checkEmptyObject(cookieName)){
          return false
        }else{
          const token = JSON.parse(cookieName);
          const h = this;
          const newToken = token.token;
          if(token.token !== " " || token.token != null || token.token !== undefined){
            const uri = urls('account/recenttransaction.php')
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
                   h.setState({
                    recentData:Data.data
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
        this._isMounted=true;
      }
  render() {
    const {recentData} = this.state
    return (
      <div className="col-lg-8">
          <div className="white_card mb_30 card_height_100">
              <div className="white_card_header ">
                  <div className="box_header m-0">
                      <div className="main-title">
                          <h3 className="m-0">Recent Transaction Activities</h3>
                      </div>
                      <Link to="/transaction/history">
                          <p>View all</p>
                      </Link>
                  </div>
              </div>
              <div className="white_card_body pt-0">
                  <div className="QA_section">
                      <div className="QA_table mb-0 transaction-table">
                          {/*-- table-responsive --*/}
                          <div className="table-responsive">

                            <table className="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Id</th>
                                            <th scope="col">Action</th>
                                            <th scope="col">Method</th>
                                            <th scope="col">status</th>

                                            <th scope="col">Amount</th>
                                            <th scope="col">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        {
                                            recentData.map((data)=>
                                                <tr key={data.transId}>
                                                    <td>{data.transId}</td>
                                        
                                                    <td>{data.transaction_type}</td>
                                                    <td>{data.transaction_name}</td>
                                                    <td><Link to="#" className={data.transaction_status==='pending'?"status_btn yellow_btn":"status_btn"}>{data.transaction_status}</Link></td>
                                                    <td>{data.amount}</td>
                                                    <td>{data.date}</td>
                                                </tr>
                                            )
                                        }   
                                                                             
                                    </tbody>
                                </table>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    )
  }
}

export default RecentActivities;

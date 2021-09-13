import React, { Component } from 'react'
import {Link} from 'react-router-dom'

import {urls} from './method'
import jQuery from 'jquery'
import {getCookie} from './cookie'

class Earnings extends Component {
    constructor(props){
        super(props)
        this.state ={
          recentData :[]
        }
        this.checkEmptyObject = this.checkEmptyObject.bind(this)
    }
    _isMounted = false;

    checkEmptyObject =(object)=>{
      return JSON.stringify(object) === JSON.stringify({})
    }
    
    componentDidMount(){
      this._isMounted = true;

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

          if(this._isMounted){
            const uri = urls('account/latestreferals.php')
            const h =this;
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
    this._isMounted=false;
  }
  render() {
    const imageIcon ={
        height:'28px',
        width:'28px'
    }
    const btn_bg = {
        background:'#fc9b9b',
        color:'black !important'
    }
    const colors ={
        color:'black',
        fontWeight: 'bold'
    }
    const {recentData} = this.state

    return (
      <div className="col-xl-12">
          <div className="row">
              <div className="col-12">
                  <div className="white_card mb_30">

                      <div className="white_card_header">
                          <div className="box_header m-0">
                              <div className="main-title">

                                  <h3 className="m-0">Top 8 Referal History</h3>

                              </div>
                          </div>
                      </div>

                      <div className="white_card_body">
                          <div className="QA_section">
                              <div className="QA_table mb-0">
                                  {/*-- table-responsive --*/}
                                  <table className="table lms_table_active2  ">
                                      <thead>
                                          <tr>
                                              <th scope="col">NO</th>
                                              <th scope="col">Username</th>
                                              <th scope="col">Phone</th>
                                              <th scope="col">status</th>
                                              <th scope="col">Date</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                      {
                                            recentData.map((data)=>
                                                <tr key={data.transId}>
                                                    <td>{data.transId}</td>
                                        
                                                    <td>{data.username}</td>
                                                    <td>{data.phone}</td>
                                                    <td>
                                                        {
                                                            data.verified==2?<Link to="#" className="status_btn pending_btn"><span style={colors}>Active</span></Link>:<Link to="#" className="status_btn" style={btn_bg}> <span style={colors}>not-active</span> </Link>
                                                        }
                                                    </td>
                                                    
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
      </div>
    )
  }
}

export default Earnings;

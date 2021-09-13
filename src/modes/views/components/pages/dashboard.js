import React, { Component } from 'react'
import Topstats from './dashboard/topstats';
import InnerContent from './dashboard/innercontent';
// import Pay from './payforclient';
import {urls} from './dashboard/inner/method'
import jQuery from 'jquery'
import {getCookie} from './dashboard/inner/cookie'


class Dashboard extends Component {
  constructor(props){
    super(props)
    this.state ={
      userStats :{}
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
        const uri = urls('account/dashboard.php')
        const h =this;
        if(this._isMounted){
          jQuery.ajax({
            url: uri,
            method: "GET",
            data: {
                token: newToken,
            },
            dataType: "html",
            success: function (data) {
               const Data = JSON.parse(data)
               h.setState({
                userStats:Data
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
    const{userStats} = this.state
    return (

      <React.Fragment>
        <Topstats userData={this.props.user} userStats={userStats}/>
        <InnerContent userData={this.props.user} userStats={userStats}/>
      </React.Fragment>
    )
  }
}

export default Dashboard;

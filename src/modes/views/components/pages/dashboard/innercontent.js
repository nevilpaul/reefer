import React, { Component } from 'react'
import Chartstats from './inner/chartstats';
import Overview from './inner/Overview';
import RecentActivities from './inner/recentactivities';
// import Exchange from './inner/exchange';
import Earnings from './inner/earnings';
import Quicktransfer from './inner/quicktransfer';

class InnerContent extends Component {
  constructor(props){
    super(props)
  }

  render() {
    const {userData,userStats} = this.props
    return (
      <div className="row">
        <Chartstats user={userData} userStats ={userStats}/>
        <Overview/>
        <RecentActivities/>
        <Quicktransfer/>
        <Earnings/>
      </div>
    )
  }
}

export default InnerContent;

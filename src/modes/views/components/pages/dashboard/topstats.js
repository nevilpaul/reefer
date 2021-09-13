import React, { Component } from 'react'


class Topstats extends Component {
  constructor(props){
    super(props)
  }

  render() {
    const {userStats} = this.props
    return (

      <div className="row">
        <div className="col-12">
            <div className="page_title_box d-flex flex-wrap align-items-center justify-content-between">
                <div className="page_title_left">
                    <h3 className="mb-0" >Dashboard</h3>
                    <p>Dashboard / Helapoint</p>
                </div>
                <div className="monitor_list_widget">
                    <div className="simgle_monitor_list">
                        <div className="simgle_monitor_count d-flex align-items-center">
                            <span>Total Transaction</span>
                            <div id="monitor_1"></div>
                        </div>
                        <h4 >ksh <span className="counter">{userStats.totalTransaction}</span> </h4>
                    </div>
                    <div className="simgle_monitor_list">
                        <div className="simgle_monitor_count d-flex align-items-center">
                            <span>Direct Refferals</span>
                            <div id="monitor_3"></div>
                        </div>
                        <h4 >ksh <span className="counter">{userStats.ReeferEarnings}</span></h4>
                    </div>
                </div>
            </div>
        </div>
      </div>

    )
  }
}

export default Topstats;

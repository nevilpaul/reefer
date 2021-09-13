import React, { Component } from 'react'
import {Link} from 'react-router-dom'
class Charts extends Component {
  render() {
    return (
      <div className="col-xl-8">
          <div className="white_card card_height_100 mb_30">
              <div className="white_card_header">
                  <div className="box_header m-0 flex-wrap">
                      <div className="main-title mb_10">
                          <h3 className="m-0">254856 USD </h3>
                          <p>125648 USD (20%)</p>
                      </div>
                      <div className="view_btns">
                          <Link to="#" className="mr_5 mb_10  small_blue_btn active">All</Link>
                          <Link to="#" className="mr_5 mb_10  small_blue_btn active">1M</Link>
                          <Link to="#" className="mr_5 mb_10  small_blue_btn">6M</Link>
                          <Link to="#" className="mr_5 mb_10  small_blue_btn">1Y</Link>
                          <Link to="#" className="mr_5 mb_10  small_blue_btn">YTD</Link>
                      </div>
                  </div>
              </div>
              <div className="white_card_body"  >
                  <div id="areaLine_chart1"></div>
              </div>
          </div>
      </div>
    )
  }
}

export default Charts;

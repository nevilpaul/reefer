import React, { Component } from 'react'
import {CopyToClipboard} from 'react-copy-to-clipboard'
import {Link} from 'react-router-dom'
class Chartstats extends Component {
  constructor(props){
    super(props)
    this.state ={
      copied:false,
      buttonText:'Copy My Link'
    }
  }

  render() {
    const {user,userStats} = this.props
    const {buttonText} = this.state
    
    return (
      <div className="col-xl-12">
        <div className="white_card  mb_30">
            <div className="white_card_header ">
                <div className="box_header m-0">
                    <ul className="nav  theme_menu_dropdown">
                        <li className="nav-item">
                          <Link className="nav-link active" to="#">Account Analytics</Link>
                        </li>
                      </ul>

                      <div className="button_wizerd">
                        <CopyToClipboard text={`http://localhost:3000/signup/helapoint?re=${user.username}`} onCopy={() => this.setState({buttonText: 'Link Copied'})}>
                          <button  className="white_btn" >{buttonText}</button>
                        </CopyToClipboard>                      
                      </div>

                </div>
            </div>
            <div className="white_card_body anlite_table p-0">
                <div className="row">
                    <div className="col-lg-4">
                        <div className="single_analite_content">
                            <h4>Expected Payout(ksh)</h4>
                            <h3><span className="counter">{userStats.wallet}</span> </h3>
                            <div className="d-flex">
                                {/* <div>3.78<i className="fa fa-caret-up"></i></div> */}
                                <span>All Time</span>
                            </div>
                        </div>
                    </div>
                    <div className="col-lg-4">
                        <div className="single_analite_content">
                            <h4>Active accounts</h4>
                            <h3><span className="counter">{userStats.activeRefer>0?userStats.activeRefer:0}</span> </h3>
                            <div className="d-flex">
                                {/* <div>3.78 <i className="fa fa-caret-up"></i></div> */}
                                <span>All Time</span>
                            </div>
                        </div>
                    </div>
                    <div className="col-lg-4">
                        <div className="single_analite_content">
                            <h4>Number of Refferals</h4>
                            <h3><span className="counter">{ userStats.allReferals>0?userStats.allReferals:0}</span> </h3>
                            <div className="d-flex">
                                {/* <div>3.78 <i className="fa fa-caret-up"></i></div> */}
                                <span>All Time</span>
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

export default Chartstats;

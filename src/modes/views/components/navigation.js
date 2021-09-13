import React,{Component} from 'react'
import {Link} from "react-router-dom";
import jQuery from "jquery"
class Navigation extends Component {
  constructor(props){
    super(props)
    this.state ={
      dash:false,
      prof:false,
      wallet:false,
      affil:false
    }
  }
  componentDidMount(){
    const url = window.location.href;
    const lastIndex = url.lastIndexOf('/')+1;
    const newStr=url.substr(lastIndex,url.length);
    const trimStr =newStr.trim(newStr)+"_nav";
    
  }
  render() {
    return(
      <React.Fragment>
        <nav className="sidebar dark_sidebar">
          <div className="logo d-flex justify-content-between">
              <Link className="large_logo" to="/dashboard"><img src={`${process.env.PUBLIC_URL}/src/img/mini_logo.png`} alt=""/></Link>
              <Link className="small_logo" to="/dashboard">Reefer</Link>
              <div className="sidebar_close_icon d-lg-none">
                  <i className="ti-close"></i>
              </div>
          </div>
          <ul id="sidebar_menu">
              <li className="dashboard_nav">
                  <Link className="" to="/dashboard" aria-expanded="false">
                      <div className="nav_icon_small">
                          <img src={`${process.env.PUBLIC_URL}/src/img/menu-icon/1.svg`} alt=""/>
                      </div>
                      <div className="nav_title">
                          <span>Dashboard</span>
                      </div>
                  </Link>
              </li>
              <li className="">
                  <Link  to="/profile" aria-expanded="false">
                    <div className="nav_icon_small">
                      <img src={`${process.env.PUBLIC_URL}/src/img/menu-icon/4.svg`} alt=""/>
                  </div>
                  <div className="nav_title">
                      <span>Profile</span>
                  </div>
                  </Link>
              </li>
              <li className="">
                  <Link to="/payforclient" aria-expanded="false">
                      <div className="nav_icon_small">
                          <img src={`${process.env.PUBLIC_URL}/src/img/menu-icon/Mail_Box.svg`} alt=""/>
                      </div>
                      <div className="nav_title">
                          <span>Pay For Client</span>
                      </div>
                  </Link>
              </li>
              <li className="">
                  <Link  to="/wallet" aria-expanded="false">
                    <div className="nav_icon_small">
                      <img src={`${process.env.PUBLIC_URL}/src/img/menu-icon/2.svg`} alt=""/>
                  </div>
                  <div className="nav_title">
                      <span>Wallet</span>
                  </div>
                  </Link>
              </li>

              <li className="">
                  <Link  to="/affiliate" aria-expanded="false">
                    <div className="nav_icon_small">
                      <img src={`${process.env.PUBLIC_URL}/src/img/menu-icon/16.svg`} alt=""/>
                  </div>
                  <div className="nav_title">
                      <span>Affiliate</span>
                  </div>
                  </Link>
              </li>


              {/*<li className="">
                  <Link  to="/transaction/request" aria-expanded="false">
                    <div className="nav_icon_small">
                      <img src={`${process.env.PUBLIC_URL}/src/img/menu-icon/5.svg`} alt=""/>
                  </div>
                  <div className="nav_title">
                      <span>Withdrawal Request</span>
                  </div>
                  </Link>
              </li>*/}
              <li className="">
                  <Link to="/transaction/history" aria-expanded="false">
                      <div className="nav_icon_small">
                          <img src={`${process.env.PUBLIC_URL}/src/img/menu-icon/6.svg`} alt=""/>
                      </div>
                      <div className="nav_title">
                          <span>Transactions</span>
                      </div>
                  </Link>
              </li>


          </ul>
        </nav>
      </React.Fragment>
    )
  }
}
export default Navigation

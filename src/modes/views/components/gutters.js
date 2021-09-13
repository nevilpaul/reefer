import React, { Component } from 'react'
import {Link} from 'react-router-dom'

export default class NoGutters extends Component {
  constructor(props){
    super(props)
  }
  render() {
    const {userData} = this.props
    return (
      <div className="container-fluid no-gutters">
        <div className="row">
            <div className="col-lg-12 p-0 ">
                <div className="header_iner d-flex justify-content-between align-items-center">
                    <div className="sidebar_icon d-lg-none">
                        <i className="ti-menu"></i>
                    </div>
                    <div className="line_icon open_miniSide d-none d-lg-block">
                        {/* <img src={`${process.env.PUBLIC_URL}/src/img/line_img.png`} alt=""/> */}
                    </div>
                    <div className="header_right d-flex justify-content-between align-items-center">
                        <div className="profile_info d-flex align-items-center">
                            <div className="profile_thumb mr_20">
                                <img src={`${process.env.PUBLIC_URL}/src/img/transfer/4.png`} alt="#"/>
                            </div>
                            <div className="author_name">
                                <h4 className="f_s_15 f_w_500 mb-0">{userData.username}</h4>
                                <p className="f_s_12 f_w_400">{userData.email}</p>
                            </div>
                            <div className="profile_info_iner">
                                <div className="profile_author_name">
                                    {/*<p></p>*/}
                                    <h5>{userData.username}</h5>
                                </div>
                                <div className="profile_info_details">
                                    <Link to="/profile">My Profile </Link>
                                    <Link to="#" onClick={this.props.logOut}>Log Out </Link>
                                </div>
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

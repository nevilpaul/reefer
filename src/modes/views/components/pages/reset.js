import React, { Component } from 'react'
import PropTypes from 'prop-types'
class Reset extends Component {
  constructor(props) {
    super(props)
  }
  render(){
    const padding ={
        paddingTop:"150px",
        overflow:"hidden"
    }
    return(
      <div className="row" style={padding}>
          <div className="col-xl-4"></div>
          <div className="col-xl-4">
              <div className="white_card card_height_100 mb_30">
                  <div className="white_card_header">
                      <div className="box_header m-0">
                          <div className="main-title">
                              <h3 className="m-0">Enter Your new Password</h3>
                          </div>
                      </div>
                  </div>
                  <div className="white_card_body">
                      <div className="exchange_widget">
                          <form  name="myform" className="currency_validate"  >
                              <div className="form-group">

                              </div>
                              <div className="form-group">
                                  <label >Enter passord</label>
                                  <div className="input-group ">
                                      <input type="password" name="usd_amount" className="form-control" placeholder="Enter new Password" value="" onChange={}/>
                                  </div>
                              </div>
                              <div className="form-group">
                                  <label >Re-enter the Password</label>
                                  <div className="input-group">
                                      <input type="password" name="Amount" className="form-control" placeholder="Re-enter the Password" value="" onChange={}/>
                                  </div>

                              </div>
                              <div className="form-group">

                              </div>
                                <button type="submit" name="button" className="btn_1 w-100" onClick={this.payNow}>Change Password</button>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
        <div className="col-xl-4"></div>
      </div>
    )
  }
}
export default Reset

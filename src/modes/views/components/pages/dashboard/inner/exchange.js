import React, { Component } from 'react'
import {converter} from './exchange-js'

class Exchange extends Component {
  constructor(props){
    super(props);
    this.state = {

        tetherValue:"125.11",
        amount:"",
        address:"",
        converted:""

    }
    this.setExchange = this.setExchange.bind(this);
    this.collector = this.collector.bind(this);
  }
  collector =(event)=>{

    const val = event.target.value;
    this.setState({
      amount:val
    });
  }
  setExchange(e){
    e.preventDefault();
    const {amount} = this.state;
    const conv= converter(amount);
    this.setState({
      converted:conv
    });
  }

  render() {
    const {converted} = this.state;
    return (
      <div className="col-xl-4">
          <div className="white_card card_height_100 mb_30">
              <div className="white_card_header">
                  <div className="box_header m-0">
                      <div className="main-title">
                          <h3 className="m-0">Exchange To Tether</h3>
                      </div>
                  </div>
              </div>
              <div className="white_card_body">
                  <div className="exchange_widget">
                      <form  name="myform" className="currency_validate"  >
                          <div className="form-group">
                              <label >Currency</label>
                              <div className="input-group ">
                                  <input type="text" name="Tether" className="form-control" value="Tether Value" disabled onChange={}/>
                                  <input type="text" name="usd_amount" className="form-control" value="125.11 USD" disabled onChange={}/>
                              </div>
                          </div>
                          <div className="form-group">
                              <label >Enter Tether Address</label>
                              <div className="input-group ">
                                  <input type="text" name="usd_amount" className="form-control" placeholder="Your Tether Address" autoComplete="off"/>
                              </div>
                          </div>
                          <div className="form-group">
                              <label >Enter your amount</label>
                              <div className="input-group">
                                  <input type="number" name="usd_amount" className="form-control" placeholder="14,525.00 ksh" onChange={this.collector} autoComplete="off"/>
                              </div>
                              {/*// <div className="d-flex justify-content-between mt-3">
                              //     <p className="mb-0">You will Recieve</p>
                              //     <h6 className="mb-0">{converted} USDT</h6>
                              // </div>*/}
                          </div>
                          <button type="submit" name="button" className="btn_1 w-100" onClick={this.setExchange}>Exchange Now</button>
                      </form>
                  </div>
              </div>
          </div>
      </div>
    )
  }
}

export default Exchange;

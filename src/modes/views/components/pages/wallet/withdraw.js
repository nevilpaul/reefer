import React, { Component } from 'react'

class Withdraw extends Component {
  constructor(props){
    super(props)
    this.state ={
      amount:"",
      number:"",
      token:""
    }
  }
  amountChange(event){
    const amount =  event.target.value;
    this.setState({
        amount:amount
    })
  }
  numberChange(event){
    const number =  event.target.value;
    this.setState({
        number:number
    })
  }
  render() {
    return (

      <div className="col-lg-8">
          <div className="white_card card_height_100 mb_30">
              <div className="white_card_header">
                  <div className="white_box_tittle">
                      <h4>Withdraw</h4>
                  </div>
              </div>
              <div className="white_card_body">
                  <div className="row">
                      <div className="col-lg-12">
                          <label >Amount <sup>Ksh</sup></label>
                          <div className="common_input mb_20">
                              <input type="text" placeholder="500" value="500" onChange={this.amountChange}/>
                          </div>
                      </div>
                      <div className="col-lg-12">
                          <label >Payment Method *Mpesa*</label>
                          <div className="common_input mb_20">
                              <input type="text"  value="254701753461" disabled onChange={this.numberChange}/>
                          </div>
                      </div>

                      <div className="col-12">
                          <div className="create_report_btn mt_30">
                              <a href="#" className="btn_1 w-100">SEND</a>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    )
  }
}

export default Withdraw;

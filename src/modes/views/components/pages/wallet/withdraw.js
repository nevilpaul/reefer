import React, { Component } from 'react'
import {Link} from 'react-router-dom'
class Withdraw extends Component {

  constructor(props){
    super(props)
    this.state ={
      amount:"",
      number:"",
      token:""
    }
    this.checkEmptyObject = this.checkEmptyObject.bind(this)
  }
  _isMounted=false;
  checkEmptyObject =(object)=>{
    return JSON.stringify(object) === JSON.stringify({})
  }
  amountChange(event){
    const amount =  event.target.value;
    if(this._isMounted){
      this.setState({
        amount:amount
      })
    }
    
  }
  numberChange(event){
    const number =  event.target.value;
    if(this._isMounted){
      this.setState({
          number:number
      })
    }
  }
  componentWillUnmount(){
    this._isMounted=false
  }
  render() {
    const {amount} =this.state
    const {phone} =this.props.user
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
                              <input type="text" placeholder="500" value={amount} onChange={this.amountChange}/>
                          </div>
                      </div>
                      <div className="col-lg-12">
                          <label >Payment Method *Mpesa*</label>
                          <div className="common_input mb_20">
                              <input type="text"  value={phone} disabled/>
                          </div>
                      </div>

                      <div className="col-12">
                          <div className="create_report_btn mt_30">
                              <Link to='#' className="btn_1 w-100">SEND</Link>
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

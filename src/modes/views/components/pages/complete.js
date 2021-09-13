import React, { Component } from 'react'
import {Redirect,Route,withRouter,Link} from "react-router-dom";
import jQuery from 'jquery'
import {urls} from './methods'
class Complete extends Component {
    constructor(props) {
    super(props);
    this.state ={
        phone:"",
    }
    this.query = this.query.bind(this);
    this.checkPhoneNumber = this.checkPhoneNumber.bind(this);
    this.payNow = this.payNow.bind(this);
  }
  _isMounted = false;
  payNow =(e)=>{
    this._isMounted = true;
    e.preventDefault();
    const {phone}= this.state
    if(this.checkPhoneNumber(phone)){
      const uri = urls('mpesaApi/curl/lipanow.php')
      const h =this;
      if(this._isMounted){
        jQuery.ajax({
          url: uri,
          method: "GET",
          data: {
              phone: phone,
              amount:1
          },
          dataType: "html",
          success: function (data) {
            const Auth = JSON.parse(data);
            console.log(Auth)
          }
        })
      }
      
    }

  }
  query =(param)=>{
    const urlParam = new URLSearchParams(this.props.location.search)
    return urlParam.get(param)
  }
  checkPhoneNumber(number){

    number = parseInt(number);
    if(typeof number == 'number' ){
      const string = number.toString();
      if(string.length == 12){
        return parseInt(string);
      }
    }else{
      return false;
    }

  }
  componentDidMount(){
    this._isMounted = true;
    var title = document.getElementById('title');
    title.innerHTML = `Complete | Reefer`;
  }
  componentWillMount=()=>{
    this._isMounted = true;
    const urlParam = this.query('tpn')

    if(urlParam != " " || urlParam != null || urlParam !=undefined ){
      console.log(urlParam)
      const uri = urls('login/credencialsCheck.php')
        const h =this;
        const valNum = this.checkPhoneNumber(urlParam)
        console.log(valNum)
        h.setState({phone:valNum})
    }

  }
  
  componentWillUnmount(){
    this._isMounted = false;
  }
  
  render() {
    const {phone} = this.state
    const padding ={
        paddingTop:"150px",
        overflow:"hidden"
    }
    return (

        <div className="row" style={padding}>
            <div className="col-xl-4"></div>
            <div className="col-xl-4">
                <div className="white_card card_height_100 mb_30">
                    <div className="white_card_header">
                        <div className="box_header m-0">
                            <div className="main-title">
                                <h3 className="m-0">Pay with M-pesa</h3>
                            </div>
                        </div>
                    </div>
                    <div className="white_card_body">
                        <div className="exchange_widget">
                            <form  name="myform" className="currency_validate"  >
                                <div className="form-group">
                                    
                                </div>
                                <div className="form-group">
                                    <label >Enter Tether Address</label>
                                    <div className="input-group ">
                                        <input type="text" name="usd_amount" className="form-control" value={phone} disabled onChange={phone}/>
                                    </div>
                                </div>
                                <div className="form-group">
                                    <label >Enter your amount</label>
                                    <div className="input-group">
                                        <input type="number" name="Amount" className="form-control" placeholder="500 ksh" value="1" disabled onChange={1}/>
                                    </div>
                                    
                                </div>
                                <div className="form-group">
                                    
                                </div>
                                <button type="submit" name="button" className="btn_1 w-100" onClick={this.payNow}>Pay Now</button>
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

export default Complete;

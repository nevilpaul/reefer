import React, { Component } from 'react'
import jQuery from 'jquery'
import {urls} from './method'


class Quicktransfer extends Component {
  constructor(props){
    super(props);
    this.state={
        balance:"0"
    }
    this.checkEmptyObject = this.checkEmptyObject.bind(this);
  }
  _isMounted=false;
  checkEmptyObject =(object)=>{
    return JSON.stringify(object) === JSON.stringify({})
  }
  componentDidMount (){
    this._isMounted=true;
      const user = localStorage.getItem('__esMode')
      if(user != " " || user != null || user != undefined){
        const uri = urls('createaccount/getwallet.php')
        const h =this;
        if(this._isMounted){
            jQuery.ajax({
                url: uri,
                method: "GET",
                data: {
                    randomId: user,
                },
                dataType: "html",
                success: function (data) {
                    const datas = JSON.parse(data);
                     h.setState({
                       balance:datas.balance
                     }) 
                }
            })
        }
        
      }else{
        return false;
      }
      
  }
  componentWillUnmount(){
    this._isMounted=false;
  }
  render() {
    const {balance} = this.state;

    var style ={
      'fontSize':'14px'
    }
    var max ={
        'width': '100%'
    }

    return (

      <div className="col-lg-4">
        <div className="white_card mb_30 card_height_100">
            <div className="white_card_header">
                <div className="box_header m-0">
                    <div className="main-title">
                        <h3 className="m-0">Account Wallet</h3>
                    </div>
                </div>
            </div>
            <div className="white_card_body pb-0">
                <div className="recent_transfer_wrapper">
                    <div className="transfer_thumb_conatnt">
                        
                        <div className="row">
                            <div className="col-lg-12">
                                
                                <img style={max}src={`${process.env.PUBLIC_URL}/src/img/transfer/a6b481c8b926aca64e7456301a224f28.jpg`} alt=""/>

                            </div>
                            
                            
                        </div>
                        <div className="row">
                            <div className="col-12">
                                <div className="eth_amount_number text-center">
                                    <p>Current Balance </p>
                                    <h3><span style={style}>Ksh</span> <span>{balance}</span></h3>
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

export default Quicktransfer;

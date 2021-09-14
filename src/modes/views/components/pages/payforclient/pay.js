import React, { Component } from 'react'
import jQuery from 'jquery'
import {urls} from '../dashboard/inner/method.js'

class Payments extends Component {
  
  constructor(props){
    super(props);
    this.state={
        balance:"0",
        usernameVal:'',
        showResult:false,
        dataArray:[],
        amount:""
    }
    this.checkEmptyObject = this.checkEmptyObject.bind(this);
    this.userSelect = this.userSelect.bind(this);
    this.searchResult = this.searchResult.bind(this);
    this.amountChange =this.amountChange.bind(this);
    this.sendNow=this.sendNow.bind(this);
  }
  _isMounted = false;
  checkEmptyObject =(object)=>{
    return JSON.stringify(object) === JSON.stringify({})
  }
  componentDidMount (){
    this._isMounted=true;
      const user = localStorage.getItem('__esMode')
      const h = this;
      if(user != "" || user != null || user !=undefined){
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
  sendNow=(e)=>{
    
    e.preventDefault();

    if(this._isMounted){
        const userId = localStorage.getItem('__esMode');
        const {amount,usernameVal,balance} = this.state
        const balString = balance.toString()
        const newNum = balString.replace(',','')
        const bal = parseInt(newNum)
        if(usernameVal !="" && bal>=amount){
            if(amount == 500){
                if(usernameVal != "" && userId !=''){
                    const uri = urls('account/subscribeforclient.php')
                    const h=this;
                    jQuery.ajax({
                        url: uri,
                        method: "POST",
                        data: {
                            username: usernameVal,
                            userId:userId,
                            amount:500
                        },
                        dataType: "html",
                        success: function (data) {
                            const datas = JSON.parse(data);
                            if(datas.error == 200){
                                alert(datas.message)
                            }                        
                        }
                    })
                }
            }else{
                alert('paying for client should be 500/=')
            }

        }else{
            alert('Please enter valid name or check if your wallet is greater or equals to 500')
        }
    }
    

  }
  searchResult(event){
    const vals = event.target.value;
    const userId = localStorage.getItem('__esMode');

    if(this._isMounted){
        this.setState({
            usernameVal:vals
        })

        if(vals != "" && userId !=''){

            const uri = urls('account/payforclient.php')
            const h=this;

            jQuery.ajax({
                url: uri,
                method: "POST",
                data: {
                    username: vals,
                    userId:userId
                },
                dataType: "html",
                success: function (data) {       
                    const datas = JSON.parse(data);
                    if(datas.length == 0){
                        return false
                    }else{
                        h.setState({
                            dataArray:datas,
                            showResult:true
                        })
                    }
                    
                }
            })
        }else{
            this.setState({
                showResult:false
            })
        }
    }
  }

  userSelect(event){
    const val =  event.target.value;
    if(this._isMounted){

        this.setState({
            usernameVal:val,
            showResult:false
        })

    }
  }
  amountChange(event){
    const amount =  event.target.value;
    if(this._isMounted){
        this.setState({
            amount:amount
        })
    }
    
  }
  componentWillUnmount(){
    this._isMounted=false;
  }
  render() {
    const {balance,usernameVal,dataArray,showResult,amount} = this.state
    
    const vals ={
        position: 'absolute',
        width:'100%',
        top: '45px',
        background: '#ededf3',
        zIndex:2,
        maxHeight:'200px',
        overflow:'auto'
    }
    const ulStyle ={
        height: 'auto',
        width: '100%'
    }
    const liStyle ={
        height: '45px',
        width: '100%',
        lineHeight: '3',
        display:'block'
    }
    const disp ={
        height: '100%',
        width: '100%',
        textAlign: 'justify',
        paddingLeft: '20px',
        border: '0px'
    }
    
    return (
        <div className="col-xl-8">
            <div className="white_card card_height_100 mb_30">
                <div className="white_card_header">
                    <div className="box_header m-0">
                        <div className="main-title">
                            <h3 className="m-0">Pay For Client</h3>
                            {
                                dataArray.map((items)=>{
                                    <div>{items.username}</div>
                                })
                            }
                        </div>
                    </div>
                </div>
                <div className="white_card_body">
                    <div className="exchange_widget">
                        <form  name="myform" className="currency_validate"  onSubmit={this.sendNow}>
                            <div className="form-group">
                                <label >Your Wallet Balance</label>
                                <div className="input-group">
                                    <input type="number" name="wallet" className="form-control" placeholder={balance} autoComplete="off" value={balance} onChange={balance}/>
                                </div>
                            </div>
                            
                            <div className="form-group">
                                <label >Enter Friend's Username</label>
                                <div className="input-group ">
                                    <input type="text" name="username" className="form-control" placeholder="username" autoComplete="off" value={usernameVal} onChange={this.searchResult}/>
                                    
                                    <div className="result" style={vals}>

                                        {showResult?<div style={ulStyle}>

                                            {
                                                
                                                dataArray.map(items=><div  style={liStyle}><input style={disp} value={items.username} type='button' onClick={this.userSelect}/></div>)
                                                
                                            }

                                        </div>:""}

                                    </div>
                                </div>
                            </div>
                            
                            <div className="form-group">

                                <label >Enter amount</label>
                                <div className="input-group ">
                                    <input type="text" name="amount" className="form-control" value={amount} onChange={this.amountChange}/>
                                </div>


                            </div>
                            <button type="submit" name="button" className="btn_1 w-100" >Pay Now</button>      
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    )
  }
}

export default Payments;

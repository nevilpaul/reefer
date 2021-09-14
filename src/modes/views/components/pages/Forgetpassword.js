import React, { Component } from 'react'
class Forget extends Component {
  constructor(props) {
    super(props)
    this.state = {
      email:""
    }
    this.emailVal = this.emailVal.bind(this);
    this.submitNow = this.submitNow.bind(this);
    this.checkEmptyObject = this.checkEmptyObject.bind(this)
  }
  _isMounted=false;
  checkEmptyObject =(object)=>{
    return JSON.stringify(object) === JSON.stringify({})
  }
  emailVal =(event)=>{
    const valMail = event.target.value;
    if(this._isMounted){
      this.setState({
        email:valMail
      });
    }
  }

  submitNow=(event)=>{
    event.preventDefault();
    const {email} =this.state;
    alert(email)

  }
  componentWillUnmount(){
    this._isMounted=false
  }
  render(){
    const {email} =this.state;
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
                              <h3 className="m-0">Enter Your Associated Email </h3>
                          </div>
                      </div>
                  </div>
                  <div className="white_card_body">
                      <div className="exchange_widget">
                          <form  name="myform" className="currency_validate"  onSubmit={this.submitNow}>
                              <div className="form-group">

                              </div>
                              <div className="form-group">
                                  <label >Enter Email</label>
                                  <div className="input-group">
                                      <input type="email" name="email" className="form-control" placeholder="Enter Email" value={email} onChange={this.emailVal}/>
                                  </div>

                              </div>
                              <div className="form-group">

                              </div>
                                <button type="submit" name="button" className="btn_1 w-100">Reset</button>
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
export default Forget

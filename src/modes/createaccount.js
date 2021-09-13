import React,{Component} from 'react'
import {Redirect,Route,withRouter,Link} from "react-router-dom";
import jQuery from 'jquery'
import Loader from "react-loader-spinner";
import axios from 'axios'
import {urls} from './methods'
import AuthO from './auth'
import {setCookie,getCookie,checkCookie,validateEmail} from './cookie'
import Success from './views/alerts/success'

class CreateAccount extends Component {
  constructor(props) {
    super(props);
    this.state = {
      firstname:"",
      lastname:"",
      username:"",
      email:"",
      password:"",
      confirmPassword:"",
      phone:"",
      referUser:"reeferinc",
      message:'',
      showMessage:false,
      redirect:false
    }
    this.firstchar = this.firstchar.bind(this);
    this.lastchar = this.lastchar.bind(this);
    this.userchar = this.userchar.bind(this);
    this.passchar = this.passchar.bind(this);
    this.phonecheck = this.phonecheck.bind(this);
    this.email = this.email.bind(this);
    this.passrepeat = this.passrepeat.bind(this);
    this.Createaccount =this.Createaccount.bind(this);
    this.setRedirect =this.setRedirect.bind(this);
    this.query = this.query.bind(this);
    this.checkPhoneNumber = this.checkPhoneNumber.bind(this);
  }
  query =(param)=>{
    const urlParam = new URLSearchParams(this.props.location.search)
    return urlParam.get(param)
  }
  componentDidMount(){

    var title = document.getElementById('title');
    title.innerHTML = `Sign Up | Reefer`;
    const urlParam = this.query('re')
    console.log(urlParam)
    if(urlParam != " " || urlParam != null || urlParam !=undefined){
      if(typeof urlParam == "string"){
        if(isNaN(urlParam) == true && urlParam.length > 5){
          this.setState({
            referUser:urlParam
          })
        }
      }  
    }
  }
  componentWillMount=()=>{
    const cName = getCookie('_AIOf');
    if(cName == null || cName == undefined ){
      return(false)
    }else{
      const token = JSON.parse(cName);

      const newToken = token.token;
      console.log(newToken)
      if(token.token != " " || token.token != null || token.token !=undefined){
        const uri = urls('login/credencialsCheck.php')
        const h =this;
        jQuery.ajax({
            url: uri,
            method: "GET",
            data: {
                token: newToken,
            },
            dataType: "html",
            success: function (data) {
               const Auth = JSON.parse(data);
               console.log(Auth)
               if(Auth.acccountComplete == 2){
                 setTimeout(() => h.props.history.push("/dashboard"), 0)
               }else if(Auth.acccountComplete == 0){
                 setTimeout(() => h.props.history.push("/complete"), 0)
               }else{
                 return false;
               }
            }
        })
      }
    }
  }

  checkLoggedIn=(status)=>{
    console.log(this.props.logginstatus);
  }
  firstchar =(event)=>{

    const val = event.target.value;
    this.setState({
      firstname:val
    });
  }
  lastchar =(event)=>{

    const val = event.target.value;
    this.setState({
      lastname:val
    });
  }
  userchar =(event)=>{

    const val = event.target.value;
    this.setState({
      username:val
    });
  }
  email=(event)=>{
    const val = event.target.value;
    this.setState({
      email:val
    });
  }
  phonecheck=(event)=>{
    const val = event.target.value;
    this.setState({
      phone:val
    });
  }
  passchar =(event)=>{

    const val = event.target.value;
    this.setState({
      password:val
    });

  }
  passrepeat =(event)=>{
    const val = event.target.value;
    this.setState({
      confirmPassword:val
    });
  }

  setRedirect(dataBoolen) {
      if (dataBoolen == 1) {
          this.setState({
              redirect: true
          });
      }
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
  Createaccount=(e)=>{

    e.preventDefault();

      const {firstname,lastname,username,email,password,phone,referUser,confirmPassword,} =this.state
      const h = this;
          var num = h.checkPhoneNumber(phone);
          if(typeof num == 'number'){
            if (this.state.username != "" &&  this.state.password != "" && this.state.password == this.state.confirmPassword  && this.state.firstname != "" && this.state.lastname != "" && this.state.phone != "" && this.state.referUser != "") {
              if(this.state.username.length >=5){
                if(validateEmail(email)){
                  jQuery.ajax({
                      url: urls('/createaccount/index.php'),
                      method: "POST",
                      data: {
                          firstname: firstname,
                          lastname: lastname,
                          username: username,
                          email: email,
                          referee: referUser,
                          phone: phone,
                          password: password,
                      },
                      dataType: "html",
                      beforeSend:function(){
                          jQuery('.allLoader').fadeIn();
                      },
                      success: function (data) {

                        data = JSON.parse(data);
                        console.log(data);
                        if(data.action == "success"){
                          h.setState({
                            message:data.message,
                            showMessage:true
                          })

                          setTimeout(() => {
                            jQuery('.allLoader').fadeOut();
                          }, 2000);

                          setTimeout(() => h.props.history.push("/complete/success?tpn="+data.phone), 3000)

                          h.setRedirect(1);
                        }else{
                          h.setState({
                            message:'Please Try again or use data that is not used to get an account',
                            showMessage:true
                          })

                        }
                        
                      }
                  
                  });

                }else{
                  alert('please enter a valid email');
                }
              }

              
            }
          }else if(typeof num == 'boolean'){
            console.log(num);
            alert('Please enter Phone number in this format "254700000000"')
          }
          
  }
  render(){
    const {firstname,lastname,username,email,password,phone,confirmPassword,message,showMessage} =this.state
    const margin={
      paddingTop: '20px',
      height: '100%',
      width: '100%',
      overflow: 'hidden'
    }
    const inlineStyle = {
        height: "100%",
        position: "fixed",
        width: "100%",
        top: "0px",
        left: "0px",
        background: "#000000fa",
        zIndex: 2,
        display:'none'
    }
    const loader = {
        left: "50%",
        top: "50%",
        position: 'absolute',
        transform: 'translate(-50%,-50%)'
    }

      return(

        <React.Fragment>

          <section style={margin}>
              {/* <Route path = {`${process.env.PUBLIC_URL}/dashboard`} static exact render = {()=>(this.state.redirect ? ( <Redirect to={{ pathname: `/dashboard`, state:{ from: this.props.location }}} /> ) :true)}/>*/}
              <div className="main_content_iner ">
                  <div className="container-fluid p-0">
                    {showMessage?<Success Message={message}/>:false}
                      <div className="row justify-content-center">
                        <div className="col-lg-12">
                          <div className="mb_30">
                              <div className="row justify-content-center">
                                  <div className="col-lg-3"></div>
                                  <div className="col-lg-6" style={margin}>

                                      <div className="modal-content cs_modal">
                                          <div className="modal-header justify-content-center">
                                              <h5 className="modal-title text_white">Create Your Account</h5>
                                          </div>
                                          <div className="modal-body">

                                              <form >
                                                <div className="row">
                                                  <div className="col-lg-6">
                                                      <label >Firstname</label>
                                                      <div className="common_input mb_20">
                                                          <input type="text" placeholder="Firstname" value={firstname} onChange={this.firstchar}/>
                                                      </div>
                                                  </div>
                                                  <div className="col-lg-6">
                                                      <label >Lastname</label>
                                                      <div className="common_input mb_20">
                                                          <input type="text" placeholder="Lastname" value={lastname} onChange={this.lastchar}/>
                                                      </div>
                                                  </div>
                                                  <div className="col-lg-6">
                                                      <label >Username</label>
                                                      <div className="common_input mb_20">
                                                          <input type="text" placeholder="Username" value={username} onChange={this.userchar}/>
                                                      </div>
                                                  </div>
                                                  <div className="col-lg-6">
                                                      <label >Reefer User</label>
                                                      <div className="common_input mb_20">
                                                          <input type="text" placeholder="Person Invited you" value={this.state.referUser} disabled/>
                                                      </div>
                                                  </div>
                                                  <div className="col-lg-6">
                                                      <label >Email</label>
                                                      <div className="common_input mb_20">
                                                          <input type="email" placeholder="Email" value={email} onChange={this.email}/>
                                                      </div>
                                                  </div>
                                                  <div className="col-lg-6">
                                                      <label >Safaricom Phone&nbsp;Number</label>
                                                      <div className="common_input mb_20">
                                                          <input type="Number" placeholder="254701000000" value={phone} onChange={this.phonecheck}/>
                                                      </div>
                                                  </div>
                                                  <div className="col-lg-6">
                                                      <label >Password</label>
                                                      <div className="common_input mb_20">
                                                          <input type="Password" placeholder="Password" value={password} onChange={this.passchar}/>
                                                      </div>
                                                  </div>
                                                  <div className="col-lg-6">
                                                      <label >Confirm Password</label>
                                                      <div className="common_input mb_20">
                                                          <input type="Password" placeholder="Confirm Password" vaue={confirmPassword} onChange={this.passrepeat}/>
                                                      </div>
                                                  </div>
                                                  <div className="form-group cs_check_box">
                                                      &nbsp;&nbsp;&nbsp;&nbsp;
                                                      <input type="checkbox" id="check_box" className="common_checkbox" />
                                                      <label for="check_box">
                                                          Keep me up to date
                                                      </label>
                                                  </div>
                                                  <button type="button" className="btn_1 full_width text-center" onClick={this.Createaccount}> Sign Up</button>
                                                  <p>Need an account? <Link data-toggle="modal" data-target="#sing_up" data-dismiss="modal"  to="/signin">Log in</Link></p>

                                                </div>
                                              </form>

                                          </div>
                                      </div>
                                  </div>
                                  <div className="col-lg-3"></div>
                              </div>

                          </div>
                        </div>
                      </div>
                  </div>
              </div>
              <div className="allLoader" style={inlineStyle}>
                  <Loader type="Rings" height={100} width={100} color="orangered" style={loader}/>
              </div>
          </section>
        </React.Fragment>
      )
  }
}
export default withRouter(CreateAccount)

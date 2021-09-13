import React,{Component} from 'react'
import {Redirect,Route,withRouter,Link} from "react-router-dom";
import jQuery from 'jquery'
import Loader from "react-loader-spinner";
import axios from 'axios'
import {urls} from './methods'
import AuthO from './auth'
import {setCookie,getCookie,validateEmail} from './cookie'
import Success from './views/alerts/success'
class Signin extends Component {
  constructor(props) {
    super(props);
    this.state = {
      username:"",
      password:"",
      redirect:false,
      message:'',
      showMessage:false
    }
    this.userchar = this.userchar.bind(this);
    this.passchar = this.passchar.bind(this);
    this.submitLogins =this.submitLogins.bind(this);
    this.setRedirect =this.setRedirect.bind(this);
    this.checkLoggedIn = this.checkLoggedIn.bind(this);
    this.credentialsCheck = this.credentialsCheck.bind(this);
    this.checkPhoneNumber = this.checkPhoneNumber.bind(this);

  }
  _isMounted=false;

  credentialsCheck =(session)=>{

  }
  componentDidMount(){
    var title = document.getElementById('title');
    title.innerHTML = `Sign In | Helapoint`;
  }
  componentWillMount=()=>{
    this._isMounted=true;
    const startSession = sessionStorage.getItem('_AIOf');
    const cName = getCookie('_AIOf');
    if(cName == null || cName == undefined ){
      return(false)
    }else{
      const token = JSON.parse(cName);

      const newToken = token.token;

      if(token.token != " " || token.token != null || token.token !=undefined){
        const uri = urls('login/credencialsCheck.php')
        const h =this;

        if(this._isMounteds){
          jQuery.ajax({
            url: uri,
            method: "GET",
            data: {
                token: newToken,
            },
            dataType: "html",
            success: function (data) {
               const Auth = JSON.parse(data);
               if(Auth.acccountComplete == 2){
                 setTimeout(() => h.props.history.push("/dashboard"), 0)
               }else if(Auth.acccountComplete == 0){
                 setTimeout(() => h.props.history.push("/complete/success?tpn="+data.phone), 0)
               }else{
                 return false;
               }
            }
          })
        }
        
      }
    }
  }
  componentWillUnmount(){
    this._isMounted =false;
  }
  checkLoggedIn=(status)=>{
    console.log(this.props.logginstatus);
  }
  userchar =(event)=>{

    const val = event.target.value;
    this.setState({
      username:val
    });
  }
  passchar =(event)=>{

    const val = event.target.value;
    this.setState({
      password:val
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
  submitLogins=(e)=>{

    e.preventDefault();
          var {username,password} =this.state;
          var h = this;
          if (username != "" &&  password != "" && validateEmail(username) || this.checkPhoneNumber(username)) {
              const {setRedirect,props,state} = this;

              jQuery.ajax({
                  url: urls('/login/index.php'),
                  method: "GET",
                  data: {
                      username: state.username,
                      password: state.password
                  },
                  dataType: "html",
                  beforeSend:function(){
                      jQuery('.allLoader').fadeIn();
                  },
                  success: function (data) {
                    
                    const newdata = JSON.parse(data);
                    if(newdata.accountType == 'user'){
                      setCookie("_AIOf", data,30)
                      setTimeout(() => {
                        jQuery('.allLoader').fadeOut();
                      }, 2000);
                      AuthO.loggedIn(
                        () => setTimeout(() => props.history.push("/dashboard"), 100)
                      );

                      setRedirect(1);
                    }else{
                      setTimeout(() => {
                        jQuery('.allLoader').fadeOut();
                      }, 2000);
                      h.setState({
                          message:newdata.message,
                          showMessage:true
                      })
                    }
                    
                  }

              })
          }else{
              this.setState({
                message:'Please check your username field if you are using Email',
                showMessage:true
              })
          }
  }
  render(){
    const {username,password,message,showMessage} =this.state
    const margin={
      paddingTop: '130px',
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
                      <h5>{showMessage?<Success Message={message}/>:false}</h5>
                      <div className="row justify-content-center">
                          <div className="col-lg-12">
                              <div className=" mb_30">
                                  <div className="row justify-content-center">
                                      <div className="col-lg-4"></div>
                                      <div className="col-lg-4">

                                          <div className="modal-content cs_modal">
                                              <div className="modal-body">
                                                <h2>Login to your account</h2>
                                                <br></br>
                                                  <form>
                                                      <div className="form-group">
                                                          <input type="text" className="form-control" placeholder="Enter your email" onChange={this.userchar} value={username}/>
                                                      </div>
                                                      <div className="form-group">
                                                          <input type="password" className="form-control" placeholder="Password" onChange={this.passchar} value={password}/>
                                                      </div>
                                                      <button type="button" className="btn_1 full_width text-center" onClick={this.submitLogins}>Log in</button>
                                                      <p>Need an account? <Link data-toggle="modal" data-target="#sing_up" data-dismiss="modal"  to="/signup/helapoint?re=ReeferInc"> Sign Up</Link></p>
                                                      <div className="text-center">
                                                          <Link to="/forgot_password" data-toggle="modal" data-target="#forgot_password" data-dismiss="modal" className="pass_forget_btn" >Forget Password?</Link>
                                                      </div>
                                                  </form>
                                              </div>
                                          </div>
                                      </div>
                                      <div className="col-lg-4"></div>
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
export default withRouter(Signin)

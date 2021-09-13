import React, { Component } from 'react'
// import Header from './views/header'
import { BrowserRouter as Router, Route ,Switch,Redirect} from "react-router-dom";
import jQuery from 'jquery'
import {urls} from './methods'
import Footer from './views/footer'
import Dynamic from './views/dynamic'
import Navigation from './views/components/navigation'
import NoGutters from './views/components/gutters'
import Dashboard from './views/components/pages/dashboard'
import Wallet from './views/components/pages/wallet'
import Profile from './views/components/pages/profile'
import Affiliate from './views/components/pages/affiliate'
import Cancel from './views/components/pages/transactions/history'
import Pay from './views/components/pages/payforclient';
import Loader from "react-loader-spinner";
import AuthO from './auth'
import {getCookie} from './cookie'

export default class FrontApp extends Component {
  constructor (props){

    super(props);
    this.state={
      session:{},
      user:{},
      successRedirect:false,
      redirect:true,
      isLoggedIn:false,
      pageLoader:true
    }
    this.checkEmptyObject = this.checkEmptyObject.bind(this);
  }
  _isMounted = false;
  
  componentWillMount =()=>{
    this._isMounted = true;

    const cookieName = getCookie('_AIOf')
    if(cookieName != null || cookieName != undefined){

      if(this._isMounted){
        this.setState ({
          isLoggedIn:true,
          session:cookieName
        });
      }
      


    }
  }
  checkEmptyObject =(object)=>{
    return JSON.stringify(object) === JSON.stringify({})
  }
  componentDidMount (){
    this._isMounted = true;
    var title = document.getElementById('title');
    title.innerHTML = `Dashboard | Helapoint`;
    const { session } = this.state;

    if(this.checkEmptyObject(session)){
      return false
    }else{
      const token = JSON.parse(session);
      const h = this;
      const newToken = token.token;
      if(token.token != " " || token.token != null || token.token !=undefined){
        const uri = urls('login/credencialsCheck.php')
        const h =this;
        if(this._isMounted){

          jQuery.ajax({
            url: uri,
            method: "GET",
            data: {
                token: newToken,
            },
            dataType: "html",
            success: function (data) {
               const Auth = JSON.parse(data)
               if(Auth.acccountComplete==2){
                localStorage.setItem('__esMode',Auth.token)
                  h.setState({
                   user:Auth,
                   pageLoader:false
                 })
                
               }else{
                  setTimeout(() => h.props.history.push("/complete/success?tpn="+Auth.phone), 10)
               }
               
            }
          })

        }
        
      }else{
        return false;
      }
    }


  }
  componentWillUnmount(){
    this._isMounted = false;
  }
  Logout =()=>{
    AuthO.loggedOut(
      () => this.props.history.push("/")
    )
  }
  render() {
    const {isLoggedIn,user} = this.state;
    const routes = [
      {
        path: "/dashboard",
        exact: true,
        main: () => <Dashboard user={user}/>
      },
      {
        path: "/wallet",
        exact:false,
        main: () => <Wallet user={user}/>
      },
      {
        path: "/profile",
        exact:false,
        main: () => <Profile user={user}/>
      },
      {
        path: "/affiliate",
        exact:false,
        main: () => <Affiliate user={user}/>
      },
      {
        path: "/payforclient",
        exact:false,
        main: () => <Pay user={user}/>
      },
      {
        path: "/transaction/history",
        exact:false,
        main: () => <Cancel user={user}/>
      }
    ];
    const inlineStyle = {
        height: "100%",
        position: "absolute",
        width: "100%",
        top: "50%",
        left: "50%",
        background: "#000000fa",
        zIndex: 1000,
        display:'block',
        WebkitTransform:'translate(-50%,-50%)'
    }
    const loader = {
        left: "50%",
        top: "50%",
        position: 'absolute',
        transform: 'translate(-50%,-50%)'
    }
    if(isLoggedIn){
      return (

        <React.Fragment>

              <div>

                <Navigation/>

                  <section  className="main_content dashboard_part large_header_bg">

                    <NoGutters logOut={this.Logout} userData={user}/>

                    <div className="main_content_iner overly_inner ">
                      <div className="container-fluid p-0 ">

                        {/* WHERE COMPONENT WILL SWITCH FROM LINK */}
                          <Switch>
                            {routes.map((route, index) => (
                              <Route
                                key={index}
                                path={route.path}
                                exact={route.exact}
                                children={<route.main/>}
                              />
                            ))}
                          </Switch>
                        {/* END OF COMPLICATION */}

                      </div>
                    </div>
                    {
                      this.state.pageLoader?(
                        <div className="allLoader" style={inlineStyle}>
                          <Loader type="Rings" height={100} width={100} color="orangered" style={loader}/>
                        </div>
                        ):false
                    }

                  </section>

                <Footer/>
                
                
              </div>


      </React.Fragment>

      )
    }else{
      return (
        <React.Fragment>


            <Redirect to={{ pathname: `/signin`, state:{ from: this.props.location }}} />

        </React.Fragment>

      )

    }

  }
}

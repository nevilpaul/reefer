import React,{Component} from 'react'
import { BrowserRouter as Router, Route ,Switch} from "react-router-dom";
import FrontApp from './modes/frontapp'
import ErrorPage from './modes/ErrorPage'
import Signin from './modes/signin'
import CreateAccount from './modes/createaccount'
import Complete from './modes/views/components/pages/complete';
import Forget from './modes/views/components/pages/Forgetpassword';
import {ProtectedRoutes} from './modes/AuthRoute'
import AuthO from './modes/auth'
class App extends Component {
  constructor(props){
    super(props);
    this.state={
      loggedIn:false,
      user:{}
    }

  }
  componentDidMount=()=>{
    let session = sessionStorage.getItem('_AIOf');

    if(session != null || session != undefined){
      AuthO.loggedIn(()=>{
        return true
      })

    }

  }
  render(){
    return(
      <Router>
        <Switch>
          <Route
            exact
            path={`${process.env.PUBLIC_URL}/`}
            render ={props =>(
              <Signin {...props} logginstatus={this.state.loggedIn}/>
            )}
          />
          <Route
            exact
            path={`${process.env.PUBLIC_URL}/signup/:handle`}
            render ={props =>(
              <CreateAccount {...props} logginstatus={this.state.loggedIn}/>
            )}
          />
          <Route
            exact
            path={`${process.env.PUBLIC_URL}/complete/:handle`}
            render ={props =>(
              <Complete {...props} logginstatus={this.state.loggedIn}/>
            )}
          />
          <Route path={`${process.env.PUBLIC_URL}/dashboard`} component={FrontApp}/>
          <Route path={`${process.env.PUBLIC_URL}/wallet`} component={FrontApp}/>
          <Route path={`${process.env.PUBLIC_URL}/profile`} component={FrontApp}/>
          <Route path={`${process.env.PUBLIC_URL}/affiliate`} component={FrontApp}/>
          <Route path={`${process.env.PUBLIC_URL}/payforclient`} component={FrontApp}/>
          <Route path={`${process.env.PUBLIC_URL}/transaction/history`} component={FrontApp}/>
          <Route path={`${process.env.PUBLIC_URL}/signin`} component={Signin}/>
          <Route path={`${process.env.PUBLIC_URL}/forgot_password`} component={Forget}/>
          <Route component={ErrorPage}/>
        </Switch>
      </Router>
    )
  }
}
export default App

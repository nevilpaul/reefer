import React, { Component } from 'react'
// import ReactDOM from "react-dom";
import { BrowserRouter as Router, Route } from "react-router-dom";
import Dashboard from './pages/dashboard';
import Wallet from './pages/wallet';
const routes = [
  {
    path: "/home",
    exact: true,
    main: () => <Dashboard/>
  },
  {
    path: "/wallet",
    exact:false,
    main: () => <Wallet/>
  }
]
class Inside extends Component {

  render() {
    return (
      <Router>
        <div className="main_content_iner overly_inner ">
          <div className="container-fluid p-0 ">

            {/* WHERE COMPONENT WILL SWITCH FROM LINK */}
            <Router>
              <switch>
                {routes.map((route, index) => (
                  <Route
                    key={index}
                    path={route.path}
                    exact={route.exact}
                    children={<route.main/>}
                  />
                ))}
              </switch>
            </Router>
            {/* END OF COMPLICATION */}

          </div>
        </div>
      </Router>
    )
  }
}

export default Inside;

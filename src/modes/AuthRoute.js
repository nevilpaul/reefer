import React from 'react'
import {Route,Redirect} from 'react-router-dom'
import AuthO from './auth'
export const  ProtectedRoutes = ({component:Component,...rest}) => {

  return (
    <Route
      {...rest}
      render={
        props => {
          if(AuthO.isAuthO()){
            return <Component {...props}/>
          }else{
            return(
              <Redirect
                to={{
                  pathname:"/",
                  state:{from:props.location}
                }}
              />
            )
          }

        }
      }
      />
  )
}

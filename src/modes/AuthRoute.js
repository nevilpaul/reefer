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
            console.log(AuthO.isAuthO()+'we are active')
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

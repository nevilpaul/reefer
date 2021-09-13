import {deleteCookie,getCookie} from './cookie'

class AuthO {
  constructor() {
    this.isLoggedIn = false
  }
  loggedIn = cb =>{
    let session = getCookie('_AIOf');
    if(session != null || session != undefined || session !=" "){
      this.isLoggedIn = true;
      cb();
    }
  }
  loggedOut=cb =>{
    let session = getCookie('_AIOf');
    console.log(session)
    if(session != null || session != undefined){
      this.isLoggedIn = false;
      deleteCookie('_AIOf')
      localStorage.removeItem('__esMode')
      cb();
    }
  }
  isAuthO =()=>{
    return this.isLoggedIn
  }

}

export default new AuthO()

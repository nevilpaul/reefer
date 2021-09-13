export const setCookie=(cname,cvalue,dateExpire)=>{
  const d =new Date();
  d.setTime(d.getTime() + (dateExpire*24*3600*1000));
  const expire = `expires = ${d.toUTCString()}`;
  document.cookie = cname+ "=" + cvalue+";" + expire +";path=/;"
}

export const getCookie =(cname)=>{
  const name =cname +"=";
  const cookie = document.cookie.split(';');
  for(let i=0;i<cookie.length;i++){
    let c = cookie[i]
    while(c.charAt(0) === ' '){
      c = c.substring(1)
    }
    if (c.indexOf(name) == 0) {
      return(c.substring(name.length, c.length));
    }

  }

}

export const checkCookie =(cookie)=>{
  const name = getCookie(cookie)
  if(name != ' '){
    return true
  }else{
    return false
  }
}

export const deleteCookie=(cookie)=>{
  const cname = cookie;
  const cvalue = " ";
  const expire = "expires=Thu, 01 Jan 1970 00:00:00 UTC";
  document.cookie = cname+ "=" + cvalue+";" + expire +";path=/;"
}

export const validateEmail=(email)=>{
  const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}

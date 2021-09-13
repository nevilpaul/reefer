export const urls=(linkDefine)=>{
  //define main my url
  const url = `http://localhost/reefer/api/${linkDefine}`;
  return url;
}
export const validateEmail=(email)=>{
  const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}
export const copyLink=(text)=>{
  text.select();
  text.execCommand('copy');
  console.log('copied');
}
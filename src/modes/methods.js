import jQuery from 'jquery'
import {useLocation} from 'react-router-dom'
export const urls=(linkDefine)=>{
  //define main my url
  const url = `http://localhost/reefer/api/${linkDefine}`;
  return url;
}

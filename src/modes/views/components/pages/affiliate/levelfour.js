import React, { Component } from 'react'
import {Link} from 'react-router-dom'
import jQuery from 'jquery'
import {getCookie} from './cookie'
import {urls} from './method'
class Levelfour extends Component {
    constructor(props) {
    super(props)
    this.state = {
        transactions:0,
    }
    this.checkEmptyObject = this.checkEmptyObject.bind(this)
    }
    _isMounted=false;
    componentDidMount(){
        this._isMounted =true;
        var title = document.getElementById('title');
        title.innerHTML = `Transactions | Helapoint`;
        const userId = localStorage.getItem('__esMode');
        if(this._isMounted ){
            this.fetchUserTransaction(userId);
        }
    }
    checkEmptyObject =(object)=>{
        return JSON.stringify(object) === JSON.stringify({})
    }
    fetchUserTransaction= userId =>{
        const cookieName = getCookie('_AIOf')
        if(this.checkEmptyObject(cookieName)){
        return false
        }else{
        const token = JSON.parse(cookieName);
        const h = this;
        const newToken = token.token;
        if(token.token !== " " || token.token != null || token.token !== undefined){
            const uri = urls('account/getLevel1.php')
            const h =this;
            if(this._isMounted){
            jQuery.ajax({
                url: uri,
                method: "POST",
                data: {
                    token: newToken,
                    levels:'level 3'
                },
                dataType: "html",
                success: function (data) {
                const Data = JSON.parse(data)
                h.setState({
                    transactions:Data.data,
                })

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
    render() {
    const {color,col} = this.props;
    const {transactions} = this.state;
    return (

      <div className={`col-lg-${col}`}>
          <div className="white_card card_height_100 mb_30 anlite_table">
              <div className="white_card_header">
                  <div className="white_box_tittle">
                      <h4 style={color}>Level four earning </h4>
                  </div>
              </div>
              <div className="white_card_body anlite_table">
                  <div className="row">
                      <div className="col-lg-12">
                          <div className="single_analite_content">
                            <h3><sub>Ksh</sub><span> {transactions} </span></h3>
                          </div>
                          
                      </div>
                  </div>
              </div>
          </div>
      </div>
    )
  }
}

export default Levelfour;

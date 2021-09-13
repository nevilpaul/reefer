import React, { Component } from 'react'
import { Link } from 'react-router-dom'

class Referelink extends Component {

  render() {
    const {color} = this.props;
    return (
      
        <div className="col-xl-12">
        <div className="white_card  mb_30">
            <div className="white_card_header ">
                <h3>Affiliate Link</h3>
                <div className="box_header m-0">
                    
                    <ul className="nav  theme_menu_dropdown">
                        <li className="nav-item">
                            <Link className="nav-link active" href="#"><h5>http://localhost:3000/signup/nevilpaul</h5></Link>
                        </li>
                    </ul>
                    <div className="button_wizerd">
                        <button className="white_btn">Copy You Link</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    )
  }
}

export default Referelink;


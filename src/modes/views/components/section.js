import React, { Component } from 'react';
import NoGutters from './gutters'
import Inside from './insidecontent'
import { BrowserRouter as Router} from "react-router-dom";


export default class Section extends Component {
  render() {
    return (

      <Router>
        <section  className="main_content dashboard_part large_header_bg">
          <NoGutters/>
          <Inside/>
        </section>
      </Router>

    )
  }
}

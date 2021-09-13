import React, { Component } from 'react';
import {appendScript} from './components/footerscripts';
class Footer extends Component {
  componentDidMount=()=>{
      appendScript('src/js/jquery-3.4.1.min.js');
      appendScript('src/js/popper.min.js');
      appendScript('src/js/bootstrap.min.js');
      // appendScript('src/js/metisMenu.js');
      

      appendScript('src/vendors/chartlist/Chart.min.js');
      appendScript('src/vendors/count_up/jquery.counterup.min.js');
      appendScript('src/vendors/niceselect/js/jquery.nice-select.min.js');
      appendScript('src/vendors/owl_carousel/js/owl.carousel.min.js');
      appendScript('src/vendors/datatable/js/jquery.dataTables.min.js');
      appendScript('src/vendors/count_up/jquery.waypoints.min.js');


      // appendScript('src/vendors/chartjs/roundedBar.min.js');

      appendScript('src/vendors/progressbar/jquery.barfiller.js');
      appendScript('src/vendors/tagsinput/tagsinput.js');
      appendScript('src/vendors/text_editor/summernote-bs4.js');
      appendScript('src/vendors/am_chart/amcharts.js');
      appendScript('src/vendors/scroll/perfect-scrollbar.min.js');

      appendScript('src/vendors/scroll/scrollable-custom.js');
      appendScript('src/vendors/vectormap-home/vectormap-2.0.2.min.js');
      appendScript('src/vendors/vectormap-home/vectormap-world-mill-en.js');
      // appendScript('src/vendors/apex_chart/apex-chart2.js');
      // appendScript('src/vendors/apex_chart/apex_dashboard.js');

      appendScript('src/vendors/chart_am/core.js');
      // appendScript('src/vendors/chart_am/charts.js');
      // appendScript('src/vendors/chart_am/animated.js');
      // appendScript('src/vendors/chart_am/kelly.js');
      appendScript('src/vendors/chart_am/chart-custom.js');

      appendScript('src/js/dashboard_init.js');
      appendScript('src/js/custom.js');

  }
  render() {
    return (
      <React.Fragment>

      </React.Fragment>
    )
  }
}

export default Footer;

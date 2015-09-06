// Settings
var settings = require('./settings'); 

/**
 * App
 * 
 */
function App(options){
  'use strict'; 
  this.element = {
    search_results: "#search-results"
  }
  this.results = false;
}

App.prototype = {

  /**
   * Load
   *
   */  
  load: function () {

    // foundation
    $(document).foundation();
    
    // make available globally via window object
    window.app = this;

    this.bindEvents();
  },

  /**
   * Bind events
   *
   */  
  bindEvents: function () {
    var that = this;
    $("form[ajax=true]").submit(function(e) { 
      e.preventDefault();
      var form_data = $(this).serialize();
      var form_url = $(this).attr("action");
      var form_method = $(this).attr("method").toUpperCase();
      $("#loadingimg").show();
 
      console.log(form_data);
      $.ajax({
        url: form_url, 
        type: form_method,      
        data: form_data,     
        cache: false,
        success: function(json){ 
          that.showResults(true);
          var html = JSON.stringify(json, null, 2);
          console.log(html);                 
          $("#search-result").html(html); 
          $("#loadingimg").hide();                    
        }           
      });    
    });
  },

  /**
   * Show Results
   *
   */  
  showResults: function (show) {
    if (this.results === false) {
      this.results = true;
      $(this.element.search_results).slideToggle(500);
    }
  
}


// Window on Load
$(window).load(function(){ 
  var app = new App();
  app.load();
});
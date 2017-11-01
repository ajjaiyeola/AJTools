function listCreate(theId, secondId, theData){
// Get the <datalist> and <input> elements.
var dataList = document.getElementById(theId);
var input = document.getElementById(secondId);
// Create a new XMLHttpRequest.
var request = new XMLHttpRequest();

// Handle state changes for the request.
request.onreadystatechange = function(response) {
  if (request.readyState === 4) {
    if (request.status === 200) {
      var jsonOptions = JSON.parse(request.responseText);
      jsonOptions.forEach(function(item) {
        var option = document.createElement('option');
        option.value = item;
        dataList.appendChild(option);
      });
      input.placeholder = "e.g. datalist"; 
    } else {
      // An error occured :(
      input.placeholder = "Couldn't load datalist options :(";
    }
  }
};
input.placeholder = "Loading options...";
request.open('GET', theData, true);
request.send();
}

listCreate('json-datalist','ajax', 'degrees.json');
listCreate('second','ajax2', 'thejobs.json');
listCreate('third','ajax3', 'industries.json');

// function for hiding and showing appropriate questions
 $(document).ready(function() {
   $('input[name="gridRadios"]').click(function() {
       if($(this).attr('id') == 'gridRadios2') {
            $('#roleQuestion').hide()   ;   
       }
          else if($(this).attr('id') == 'gridRadios1' || 'gridRadios3' ){

          $('#roleQuestion').show()   ; 
        }

       });
});

 $(document).ready(function() {
   $('input[name="gridRadios1"]').click(function() {
       if($(this).attr('id') == 'gridRadios5') {
            $('#industryQuestion').hide()   ;   
       }
          else if($(this).attr('id') == 'gridRadios4' || 'gridRadios6' ){

          $('#industryQuestion').show()   ; 
        }

       });
});

 //if user clicks suggested jobs, copy value of link into textbox
 $(document).ready(function() {
   $('div.options a').click(function() {
    var valuetouse = ($(this).text()).replace(",","");
      ($('.thejobvalue').val(valuetouse));

    });
});



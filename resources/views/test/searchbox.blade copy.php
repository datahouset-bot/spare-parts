<!-- Include jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- HTML for the search box -->
<input type="text" id="account_name" name="account_name" value ="" placeholder="Search Account Name">

<!-- HTML element to display search results -->
<div id="search_results"></div>

<!-- JavaScript script -->
<script>
  $(document).ready(function(){
      $("#account_name").on('keyup', function(){
          var value = $(this).val();

          $.ajax({
              type: "GET",
              url: "{{ URL('/searchAccount') }}", // Use the named route
              data: {'account_name': value},
              success: function(data) {
                  // Handle the response
                  // Display the search results
                  var results = data.results;
                  var html = '';

                  // Loop through the results and create HTML elements to display them
                  results.forEach(function(result) {
                      html += '<div>' + result.account_name + '</div>'; // Assuming 'account_name' is the field you want to display
                  });

                  // Update the HTML content of an element with id 'search_results'
                  $("#search_results").html(html);
              },
              error: function(xhr, status, error) {
                  console.error(xhr.responseText);
              }
          });
      });
  });
</script>


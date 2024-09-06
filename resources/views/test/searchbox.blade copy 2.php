<!-- Include jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- HTML for the search box -->
<div class="container">
    <div class="col-md-6">
        <input type="text" id="account_name" name="account_name" value="" placeholder="Search Account Name" autocomplete="off">
        <input type="text" id="account_id" name="account_id" value="" autocomplete="off">
    </div>
</div>

<!-- HTML element to display search results -->
<select id="search_results" size="5"></select>

<!-- JavaScript script -->
<script>
    $(document).ready(function(){
        $("#account_name").on('keyup', function(){
            var value = $(this).val();

            // Clear the account_id input box if the account_name input box is empty
            if (value === '') {
                $("#account_id").val('');
            }

            $.ajax({
                type: "GET",
                url: "{{ URL('/searchAccount') }}", // Use the named route
                data: {'account_name': value},
                success: function(data) {
                    // Handle the response
                    // Display the search results
                    var results = data.results;
                    var html = '';

                    // Loop through the results and create HTML option elements to display them
                    results.forEach(function(result) {
                        html += '<option value="' + result.id + '">' + result.account_name + '</option>'; // Assuming 'account_name' is the field you want to display
                    });

                    // Update the HTML content of the select element with id 'search_results'
                    $("#search_results").html(html);

                    // If there is only one search result, automatically pass its value to the input box
                    if (results.length === 1) {
                        $("#account_name").val(results[0].account_name);
                        $("#account_id").val(results[0].id);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });

        // Event listener for selecting an option from the list
        $("#search_results").change(function() {
            // Get the selected option's value (ID)
            var selectedId = $(this).val();
            // Get the selected option's text (account name)
            var selectedName = $("#search_results option:selected").text();
            // Set the value of the input box to the selected account name
            $("#account_name").val(selectedName);
            // Set the value of the account_id input box to the selected account ID
            $("#account_id").val(selectedId);
            // If you want to do something with the selected ID, you can use it here
            console.log("Selected ID:", selectedId);
        });
    });
</script>

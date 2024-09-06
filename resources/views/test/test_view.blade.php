@php
include(public_path('cdn/cdn.blade.php'));
@endphp

@extends('layouts.blank')
@section('pagecontent')
    









    <div class="card my-4 mx-4">
        <div class="card-header mx-2 my-2">
         Amc Form 
        </div>



      <div class="row mx-2">
        <div class="col-md-4">
          <div class="col-md-12 my-2">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
              Add Customer 
     
                </button>

          </div>
          <div class="co-md-12">

            <input type="text" id="account_name" name="account_name" value="" placeholder="Search Account Name" autocomplete="off">

            <input type="text" id="account_id" name="cust_name" value="" autocomplete="off">
        </div>        
          <select id="search_results" size="5" class="my-2"></select>


          </div>

        <div class="col-md-4">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis minima nihil repellat voluptas eius modi ad quam nesciunt nulla? Voluptatum in eaque soluta earum non necessitatibus aliquid, quibusdam incidunt similique?
        </div>
        <div class="col-md-4">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis minima nihil repellat voluptas eius modi ad quam nesciunt nulla? Voluptatum in eaque soluta earum non necessitatibus aliquid, quibusdam incidunt similique?
        </div>
      </div>


    <!-- HTML for the search box -->
        <div class="col-md-12">
            
        </div>
    </div>
    
    <!-- HTML element to display search results -->



     
   
          
    </div></div>
        
          <div class="container mt-5">
            
    
        {{------------------------------------- model  --}}
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New Account</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form id= "my-form">
                            @csrf

                            
                            <div class="row mb-3">
                                <div class="col-md-8">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="account_name" type="text" name="account_name" value="{{ old('account_name') }}" />
                                      <span class="text-danger"> 
                                        @error('account_name')
                                        {{$message}}
                                            
                                        @enderror
                                      </span>
                                        <label for="account_name">Account Name </label>
                                       
                                    </div>
                                </div>

                                <div class="col-md-6 mt-2">
                                  
                                  
                                  <div class="form-floating mb-3 mb-md-0">
                                       
                                         
                                    <select name="account_group" Id ="account_group"class="form-select" aria-label="Default select example">
                                      <option selected disabled>Select</option>
                                      
                                      <option value="Customer">Customer</option>
                                      <option value="Field Staff">Field Staff</option>       
                                      <option value="Expense">Expense</option>
                                      <option value="Income">Income</option>
                                      <option value="Supplier">Supplier</option>
                                      <option value="Other">Other</option>

                                      
                                    </select>
                                      <label for="account_group">Account Group  </label>
                                     
                                  <span class="text-danger"> 
                                    @error('account_group')
                                    {{$message}}
                                        
                                    @enderror
                                  </span>

                                    </div>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="op_balnce" type="text" name="op_balnce" value="{{ old('op_balnce') }}" />
                                      <span class="text-danger"> 
                                        @error('op_balnce')
                                        {{$message}}
                                            
                                        @enderror
                                      </span>
                                        <label for="op_balnce">Opning Balance </label>
                                       
                                    </div>

                                </div>    



                                <div class="col-md-4 mt-2">

                                  
                                    <div class="form-floating mb-3 mb-md-0">
                                       
                                         
                                        <select name="balnce_type" Id ="balnce_type"class="form-select" aria-label="Default select example">
                                          <option selected disabled>Select</option>
                                          
                                          <option value="Dr">Dr</option>
                                          <option value="Cr">Cr</option>       
                                          
                                        </select>
                                          <label for="balnce_type">Balance_type  </label>
                                         
                                      <span class="text-danger"> 
                                        @error('balnce_type')
                                        {{$message}}
                                            
                                        @enderror
                                      </span>

                                      
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="address" type="text" name="address" value="{{ old('address') }}" />
                                      <span class="text-danger"> 
                                        @error('address')
                                        {{$message}}
                                            
                                        @enderror
                                      </span>
                                        <label for="address">Address</label>
                                       
                                    </div>

                                </div>  
                                <div class="col-md-4 mt-2">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="city" type="text" name="city" value="{{ old('city') }}" />
                                      <span class="text-danger"> 
                                        @error('city')
                                        {{$message}}
                                            
                                        @enderror
                                      </span>
                                        <label for="city">City</label>
                                       
                                    </div>

                                </div>    
                                <div class="col-md-4 mt-2">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="phone" type="text" name="phone" value="{{ old('phone') }}" />
                                      <span class="text-danger"> 
                                        @error('phone')
                                        {{$message}}
                                            
                                        @enderror
                                      </span>
                                        <label for="phone">Phone</label>
                                       
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="mobile" type="text" name="mobile" value="{{ old('mobile') }}" />
                                      <span class="text-danger"> 
                                        @error('mobile')
                                        {{$message}}
                                            
                                        @enderror
                                      </span>
                                        <label for="mobile">Mobile</label>
                                       
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="emial" type="text" name="email" value="{{ old('email') }}" />
                                      <span class="text-danger"> 
                                        @error('email')
                                        {{$message}}
                                            
                                        @enderror
                                      </span>
                                        <label for="email">Email</label>
                                       
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="person_name" type="text" name="person_name" value="{{ old('person_name') }}" />
                                      <span class="text-danger"> 
                                        @error('person_name')
                                        {{$message}}
                                            
                                        @enderror
                                      </span>
                                        <label for="person_name">Contact Person Name </label>
                                       
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="gst_no" type="text" name="gst_no" value="{{ old('gst_no') }}" />
                                      <span class="text-danger"> 
                                        @error('gst_no')
                                        {{$message}}
                                            
                                        @enderror
                                      </span>
                                        <label for="gst_no">GST No </label>
                                       
                                    </div>

                                </div>
                                <div class="col-md-4 mt-2">
                                  <div class="form-floating mb-3 mb-md-0">
                                      <input class="form-control" id="state" type="text" name="state" value="{{ old('state') }}" />
                                    <span class="text-danger"> 
                                      @error('state')
                                      {{$message}}
                                          
                                      @enderror
                                    </span>
                                      <label for="state">State </label>
                                     
                                  </div>

                              </div>
                               
            

                                
                                
                                        
                            </div>
                                




                            
                            <div class="mt-4 mb-0">
                                <div class="d-grid">
                                    <button type="submit" id= "btnsubmit" class="btn btn-primary btn-block">Save</button>
                                    </div>
                            </div>

                            <span id= "output"></span>

                        
                        </form>
                         
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    
        <script>
            $('#myModal').on('shown.bs.modal', function () {
                $('#myModal').trigger('focus');
            });
        </script>

{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script>
    $('.myitem').chosen();   //remove this for data fatching 
    $('.mycustomer').chosen();
</script>   --}}



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  

    
    <script> // insert data into table uing ajex 
    $(document).ready(function(){
      $("#my-form").submit(function(event){
        event.preventDefault();
        var form= $("#my-form")[0];   //this lien select the form 
        var data=new FormData(form);      //this line pass  form  data to variable 
        $("#btnsubmit").prop("disabled",true)    //disable sumit button 

        $.ajax({

            type:"POST",
            url:"{{  url('\savecustomer')  }}",
            data:data,
            processData:false,
            contentType:false,
            success:function(data){
                // alert (data.res);   testing the reponse genrated from controller or not
                $('#output').text(data.res); 
                   $("#btnsubmit").prop("disabled",false)    //enable sumit button    
                   $("input[type='text']").val('');          // empty the input text box of all 

            },
            error:function(e){
                $('#output').text(e.responseText);
                // console.log(e.responseText);  // show error on log 
                $("#btnsubmit").prop("disabled",false)    //enable sumit button 
                $("input[type='text']").val('');          // empty the input text box of all 



            }


        });

      });


    });
    </script>
    



         



         <!-- Include jQuery library -->

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


  
@endsection
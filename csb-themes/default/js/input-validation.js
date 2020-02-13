/*
Author:     colmeye
Purpose:    Allow simple responsive input validation options in Bootstrap 4.

Usage:
        1. Add .form-control class to all inputs.

        2. Paste this code near bottom of page:
                <script type="text/javascript" src="<?php echo $BASE_URL;?>csb-themes/default/js/input-validation.js"></script>
                <script type="text/javascript">
                // Validation code goes here
                </script>

        3. Use the following function to check for string issues:
                checkString(inputName, minLength, maxLength, illegalCharArray)

        4. Note: This script uses the NAME of the input, NOT the id.
*/


var validC = "is-valid";
var invalidC = "is-invalid";


function checkString(inputName, minLength, maxLength, illegalCharArray)
{

    var input = $('input[name ="' + inputName + '"]');
    var illegalsUsed = "";

    $(function(){
        

        // Check String Length when changing the input
        $(input).on('input', input, function()
        {
            if (input.val().length > minLength)
            {
                // LONG ENOUGH
                // Check if too long
                if (input.val().length < maxLength)
                {
                    // GOOD LENGTH
                    
                    // Check if input contains illegal characters
                    // Reset loop string
                    illegalsUsed = "";
                    // loop through each illegal item to check for
                    $(illegalCharArray).each(function(i)
                    {
                        if (input.val().indexOf(this) >= 0)
                        {
                            // Append illegal strings to var
                            illegalsUsed += "'" + this + "' ";   
                        }
                    });

                    // Create output based on result of illegals concatination
                    if (illegalsUsed === "")
                    {
                        makeValid(input);
                    }
                    else
                    {
                        makeInvalid(input);
                        generateFeedback(input, inputName, "invalid-feedback", "Cannot use: " + illegalsUsed);
                    }

                    
                    
                }
                else
                {
                    // TOO LONG
                    makeInvalid(input);
                    generateFeedback(input, inputName, "invalid-feedback", "Too long");
                    $("#btnSubmit").attr("disabled", true);
                }
            }
            else
            {
                // TOO SHORT
                makeInvalid(input);
                generateFeedback(input, inputName, "invalid-feedback", "Too short");
            }    
        });
      
    
    });
}








function checkInt(inputNameArray, minVal, maxVal, illegalValArray)
{

}

function checkRegistrationPassword(inputName, inputNameCheck, minLength, maxLength, complexCharAmount, numberAmount)
{

}




  ////////////////////
 // CLASS UPDATING //
////////////////////

// Adds a valid class to element and removes invalid
function makeValid(element)
{
    if (!element.hasClass(validC))
    {
        element.addClass(validC);
    }
    // Remove invalid class if it exists
    if (element.hasClass(invalidC))
    {
        element.removeClass(invalidC);
    }
}

// adds invalid class to element and removes valid class
function makeInvalid(element)
{
    if (!element.hasClass(invalidC))
    {
        element.addClass(invalidC);
    }
    // Remove valid class
    if (element.hasClass(validC))
    {
        element.removeClass(validC);
    }
}

// Creates responsive tiny text below inputs to inform user of issues
function generateFeedback(input, inputName, validityClass, prompt)
{
/*
validity classes: valid-feedback or invalid-feedback
*/
    if ($('#' + inputName + '-feedback').length)
    {
        // Delete feedback if it already exists to make room for new content
        $('#' + inputName + '-feedback').remove();
        // Create new content
        $("<div id='" + inputName + "-feedback' class='" + validityClass + "'>" + prompt + "</h2>").insertAfter(input);
        
    }
    else
    {
        // Create feedback element if it does not exist
        $("<div id='" + inputName + "-feedback' class='" + validityClass + "'>" + prompt + "</h2>").insertAfter(input);
    }
}
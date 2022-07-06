<?
#
# CMS texts - edit only if you know what you're doing
#

$monthNames = array("January", "February", "March", "April", "May", "June", "July",
"August", "September", "October", "November", "December");

$dayNames = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");

# TransferStatus
$StatusDescription = array(
    '1' =>    'New',
    '2' =>    'Active',
    '3' =>    'Canceled',
    '4' =>    'Refunded',
    '5' =>    'No-Show',
    '6' =>    'DriverError',
    '7' =>    'Completed'
);


# Driver Confirmation Status
$ConfirmationStatus = array(
    '0' =>    'NoDriver',
    '1' =>    'Informed',
    '2' =>    'Accepted',
    '3' =>    'Declined',
    '4' =>    'Refunded',
    '5' =>    'No-Show',
    '6' =>    'DriverError',
    '7' =>    'Completed'
);


$SettingsDesc = array(
    'currency' =>  'Currency abbr.',
    'slideshow' =>  'Home Page Slideshow',
    'widgetOnHome' =>  'Show Header Block on Home',
    'widgetOnAbout' =>  'Show Header Block on About Us',
    'widgetOnTC' =>  'Show Header Block on Terms and Conditions',
    'widgetOnHowToBook' =>  'Show Header Block on How to book',
    'widgetOnContact' =>  'Show Header Block on Contact Us',
    'siteTheme' => 'Site theme',
    'titlePrefix' => 'Title Prefix'
);

//define("CURRENCY_SHORT", "USD");

# Language Names
define("ENGLISH", "English");
define("GERMAN", "German");
define("FRENCH", "French");
define("ITALIAN", "Italian");
define("SPANISH", "Spanish");


# Actions
define("A_EDIT", "Edit");
define("A_DELETE", "Delete");
define("A_NEW", "New");
define("SAVE", "Save");
define("CLOSE", "Close");
define("CANCEL", "Cancel");
define("UPDATE", "Update");
define("A_PRINT", "Print");
define("ARE_YOU_SURE", "Are You sure?");

$YES_NO_CHOICE = array(
                '0' => 'No', 
                '1' => 'Yes'
                ) ;

define("ADDED", "Added");
define("NOT_ADDED", "Not Added");
define("ERROR", "Error");
define("COMPLETED", "Completed");

# Menu options
define("M_DASHBOARD", "Dashboard");
define("M_TRANSFERS", "Transfers");
define("M_TRANSFERS_FOR_DATE", "List of transfers for date");
define("M_PRICES", "Prices");
define("M_PLACES", "Places");
define("M_ROUTES", "Routes");
define("M_VEHICLES", "Vehicles");
define("M_SETTINGS", "Settings");
define("M_ADMINISTRATION", "Administration");
define("M_CONTENT", "Content");
define("M_HOME_PAGE_IMAGES", "Slideshow Images");
define("M_MY_DRIVERS", "My Drivers");

define("M_COMPANY_INFO", "Company Info");
define("M_SITE_CONTENT","Site content");
define("M_SITE_SETTINGS", "Site settings");
define("M_CHANGE_PASSWORD", "Change Password");
define("M_PAYMENTS", "Payment Gateway");
define("M_CODES", "Additional Scripts");
define("M_AUTOUPDATE", "System Updates");

define("M_PREVIEW_SITE", "View Site");
define("M_LOGOUT", "Logout");
define("LOGIN", "Login");

# Administration

    # Vehicles
    define("VEHICLES", "Vehicles");
    define("VEHICLE_NAME", "Vehicle Name");
    define("VEHICLE_TYPE", "Veh.Type");
    define("VEHICLE_CAPACITY","Max.Pax");
    define("VEHICLE_IMAGE", "Image");
    define("DISCOUNT", "Discount");
    define("EDIT_VEHICLE", "Edit Vehicle");
    define("DELETE_VEHICLE", "Delete Vehicle");
    define("REMOVE_VEHICLE", "Remove");
    define("ADD_VEHICLE", "Add Vehicle");

    define("CHANGES_SAVED", "Changes saved");
    define("CHANGES_NOT_SAVED", "Changes not saved");
    define("VEHICLE_NOT_ADDED", "Vehicle not added");
    define("VEHICLE_NOT_UPDATED", "Vehicle not updated");

    define("DELETE_CONFIRM", "Deleting this will delete all depending Prices.".JNL.JNL."Are You Sure?");

    # Routes
    define("ROUTES", "Routes");
    define("ROUTE", "Route");
    define("NAME", "Name");
    define("FROM", "From");
    define("TO", "To");
    define("KM", "Km");
    define("DURATION", "Duration");
    define("ACTIVE", "Active");
    define("ROUTE_SAVED", "Route saved.");
    define("ROUTE_EXISTS", "Route already exists. Not saved!");
    define("ROUTE_DELETED", "Route and all depending Prices are deleted.");
    define("SET_NEW_PRICES",
    "<h5>Set prices for this Route</h5>
    You can set prices for the new Route here, or you can set them later using Prices option.
    ");
    define("PRICE","One-way Price");
    define("PRICE_CLASS", "Price Categories");
    define("DESCRIPTION", "ID");
    define("PERCENT", "Percent");
    define("ID", "SysId");

# Site content
    define("HOME", "Home");
    define("ABOUT_US", "About Us");
    define("HOW_TO_BOOK", "How to book");
    define("TERMS_AND_CONDITIONS", "Terms and Conditions");
    define("HTML_BLOCK", "HTML Block (shown if Slideshow is off)");
    define("SIDEBAR_BLOCK", "Sidebar Block");
    define("REFUND_POLICY", "Refund Policy");
    define("PRIVACY_POLICY", "Privacy Policy");

    # Company Info
    define("CO_NAME","Company Name");
    define("CO_ADDRESS", "Address");
    define("CO_CITY", "City");
    define("CO_ZIP", "Zip Code");
    define("CO_EMAIL", "E-mail");
    define("CO_TEL", "Tel.");
    define("CO_FAX", "Fax");
    define("CO_COUNTRY", "Country");
    define("CO_FACEBOOK", "Facebook URL");
    define("CO_TWITTER", "Twitter URL");
    define("CO_LINKEDIN", "LinkedIn URL");
    define("CO_YOUTUBE", "Youtube URL");
    define("CO_GOOGLEPLUS", "Google+ URL");

    define("CO_ABOUT", "About Us");

# Transfers
    define("ALL_TRANSFERS", "All Transfers");
    define("DETAILS_ID", "ID");
    define("DATE", "Date");
    define("TIME", "Time");
    define("PAX_NO", "Pax");
    define("PAX_NAME", "Pax Name");
    define("STATUS", "Status");
    define("DRIVER", "Driver");
    define("VEHICLE", "Vehicle");
    define("NOT_FOUND", "Not found");

    # Form
    define("ORDER_KEY","Order Key");
    define("ORDER_ID","Order ID");
    //define("STATUS","Status");

    define("FIRST_NAME","First Name");
    define("LAST_NAME","Last Name");
    //define("NAME","Name");
    define("ADDRESS","Address");

    define("FLIGHT_NO","Flight No");
    define("FLIGHT_TIME","Flight Time");

    define("PICKUP_DATE","Pick-up Date");
    define("PICKUP_TIME","Pick-up Time");
    define("PICKUP_NAME","Pick-up Name");
    define("PICKUP_POINT","Pick-up Place");
    define("PICKUP_ADDRESS","Pick-up Address");
    define("PICKUP_NOTE","Pick-up Note");

    define("DROPOFF_DATE","Drop-Off Date");
    define("DROPOFF_TIME","Drop-Off Time");
    define("DROPOFF_NAME","Drop-Off Name");
    define("DROPOFF_POINT","Drop-Off Place");
    define("DROPOFF_ADDRESS","Drop-Off Address");
    define("DROPOFF_NOTE","Drop-Off Note");

    define("CHANGE_TRANSFER_STATUS", "Change Transfer Status");
    define("NEW_STATUS", "New status");
    
    define("MESSAGE_TO_DRIVER", "Message to Driver");
    define("SET_DRIVER_AND_SEND_MSG", "Set driver and send message");


# Home Page Images
    define("HOME_PAGE_IMAGES", "Slideshow Images");
    define("EDIT_IMAGE", "Update or Delete Image");
    define("NEW_IMAGE", "Add New Image from your computer");
    define("IMAGE_INSTRUCTIONS", "Images should be max. 640px wide and 350px high. Try to keep file size as small as possible to reduce home page loading time.<br/>All images <b>must</b> have the same dimensions!");

# My Drivers
	define("PASSWORD","Password");
	define("TELEPHONE", "Tel. / Mobile");
	define("NOTES", "Notes");


# Calendar
    define("CALENDAR_VIEW", "Calendar");
    define("TRANSFER_DETAILS", "Transfer Details");

# Places

    define("PLACE_ADDRESS", "Address");
    define("PLACE_CITY", "City");
    define("PLACE_COUNTRY", "Country");
    define("PLACE_NAME", "Name");
    define("SEO_LINK", "SEO Link");
    define("PLACE_TYPE", "Type");
    define("PLACE_DESC", "Description");
    define("ON_ISLAND", "On Island");
    define("SEARCH", "Search...");

# Dashboard
    define("SUMMARY", "Summary");
    define("TODO", "To-Do List");
    define("TR_TODAY", "Transfers for today");
    define("TR_TMRW", "Transfers for tomorrow");
    define("TR_15DAYS", "Transfers within next 15 days");
    define("STATS_BY_STATUS", "Transfers by Status");
    define("BOTTOM_LINE", "The Bottom Line");

# Booking
    define("PLEASE_SELECT", "Please select...");
    define("ONE_WAY_TRANSFER", "One Way Transfer");
	define("RETURN_TRANSFER", "Return transfer");
	define("FREE_TRANSFER", "Freeform transfer");
	define("PASSENGER_INFO", "Passenger Info");
	define("EMAIL", "E-mail Address");
	define("CREDIT_CARD_DETAILS", "Credit Card Details");
    define("CARD_TYPE","Card Type");
    define("CARD_NAME","Card holder name");
    define("CARD_NUMBER", "Card Number");
    define("CARD_CVC","Control Number (CVC)");
    define("CARD_EXP_DATE","Expiration date");
    define("T_PRICE","Price for this transfer");
    define("TOTAL_PRICE", "Total Price");

    define("DISCOUNT_CODE", "Enter discount code (optional)");
    define("F_FINISH", "Finish Booking and Save Transfer");
    
# Change Password
    define("NEW_USER_NAME", "User Name");
    define("NEW_PASSWORD", "New Password");
    define("NEW_PASSWORD_AGAIN", "New Password Again");
    define("PASSWORD_SAVED", "New User Name / Password are saved.");
    define("SHOWING_ALL", "Showing all");
    
# Print Order Page
    define("INTERNAL_USE", "* Internal use only!");
    define("USE_BROWSER_PRINT", "You can use your browser's Print function to print this page (right-click, select Print).");
    define("TRANSFER_ID", "Transfer ID");
    define("BOOKING_DATE_TIME", "Booking date-time");
    
# Login Page
    define("ADMIN_LOGIN", "Administrator Login");
    define("USERNAME", "User Name");
    define("PASSWORD", "Password");
    define("LOGIN_FAILED", "Login Failed!");
    define("USE_BOTH", "Please use both your User Name and Password to access your account.");
    
# Special Codes Page
    define("BODY_CODES", "Body scripts");
    define("HEADER_CODES", "Head scripts");
    define("SCRIPTS_WARNING", "Warning: Please be careful when editing this.<br/>
                               If you are not sure what you're doing, leave this to a professional.<br/>
                               The content of this field may cause security issues or completely disable your
                               web site. 
                               ");
# Payment Gateway
    define("ACTIVATE", "Activate");                               
                               
# Confirmation - Thank You Page
    define("THANK_YOU", "Thank You");
    define("CONFIRMATION_SENT", "We have sent you a confirmation for this transfer.");
    define("CHECK_MAILBOX", "Please check your mailbox in a minute or two...");
    define("HELLO", "Hello");
    define("NEW_TRANSFER", "You have a new transfer!");
    define("AMOUNT", "Amount");
    define("FROM", "From");
    define("TO", "To");
    define("DATE", "Date");
    define("TIME", "Time");
    define("VEHICLE", "Vehicle");
    define("PASSENGERS", "Passengers");
    define("BEST_REGARDS", "Best regards");
    define("NEW_TRANSFER_MAIL", "New Transfer Order");
    define("ORDER_KEY", "Order Key");
    define("ORDER_DATE_TIME", "Order Date/Time");
    define("PASSENGER_DATA", "Passenger data");
    define("TOTAL", "Total");
    define("TRANSFER_CODE", "Transfer Code");
    define("TERMS_ACCEPTED", "You have accepted our Terms and Conditions.");
    define("FURTHER_COMM", "In all further communications please state your Order Key!");
    define("TAXI_TRANSFER_RESERVATION", "Taxi Transfer Reservation");
    define("PLEASE_PRINT", "Please print this E-mail and show it to your driver!");                               
        

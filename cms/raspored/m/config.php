<?
#
# Constants definitions
#
# Translate only text enclosed on the right side
# example: define("DO_NOT_TRANSLATE_THIS", "Translate this text only");

# Do not alter
define("NL", '<br/>'); // newline char for tooltips
# End of Do not alter

define("SITE_URL","https://".$_SERVER['SITE_URL']."/cms/raspored/m/");

define("SITE_NAME","JamTransfer");
define("SITE_MAIL","bogo@jamtransfer.com");

$host = 'localhost';
//$user = 'jamtrans_cezar';
$user = 'jamtrans_cms';

//$pass = '3WLRAFu;E_!F';
$pass = '~5%OuH{etSL)';

$db   = 'jamtrans_touradria';

define("DB_PREFIX","tc_");

# Our Commission
define("TAXIDO_COMM",0.15);


$monthNames = array("January", "February", "March", "April", "May", "June", "July",
"August", "September", "October", "November", "December");

$dayNames = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");

$YES_NO_CHOICE = array('0' => 'No', '1' => 'Yes') ;

$StatusDescription = array(
    '1' =>    'Booked',
    '2' =>    'Charged',
    '3' =>    'Canceled',
    '4' =>    'Refunded',
    '5' =>    'No-show',
    '6' =>    'DriverError',
    '7' =>    'Completed'
);

$CompletitionStatus = array(
    '0' =>    'NoDriver',
    '1' =>    'NoDriver',
    '2' =>    'Assigned',
    '3' =>    'Canceled',
    '4' =>    'Refunded',
    '5' =>    'No-show',
    '6' =>    'DriverError',
    '7' =>    'Completed'
);


# DataTables lang
define("DT_LANGUAGE","english");

# Home page
define("NO_USER",'Guest');

# User types for Registration
define("AGENT_USER","2");
define("IFRAME_USER","5");
define("API_USER","6");
define("DRIVER_USER","31");
define("OPERATOR_USER","41");
define("ADMIN_USER","91");
define("SYSADMIN_USER","99");


define("AGENTUSER","Agent");
define("IFRAMEUSER","iFrame User");
define("APIUSER","API User");
define("DRIVERUSER","Driver");
define("OPERATORUSER","Operator");
define("ADMINUSER","Administrator");
define("SYSADMINUSER","System Administrator");

# Orders
define("ORDER_KEY","Order Key");
define("ORDER_ID","Order ID");
define("STATUS","Status");

define("FIRST_NAME","First Name");
define("LAST_NAME","Last Name");
define("NAME","Name");
define("ADDRESS","Address");

define("FLIGHT_NO","Flight No");
define("FLIGHT_TIME","Arrival or Departure Time");

define("NO_OF_PASSENGERS","Number of Passengers");
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

# Driver - Active Transfers
define("SET_VEHICLE","Set");
define("TRANSFER","Transfer");

# My Account
define("MY_ACCOUNT","My Account");
define("ERROR_UPDATE_FAILED","Error. Update Failed.");
define("ACCOUNT_UPDATED","Account Updated.");

# Common
define("USER_NAME","User Name");
define("REAL_NAME","Real Name");
define("PASSWORD","Password");
define("E_MAIL","E-mail");
define("TELEPHONE","Telephone");
define("GSM_PHONE","GSM");
define("COMPANY","Company");
define("COMPANY_DESC","Company Description");
define("WEB_SITE","Web Site");
define("COMPANY_TAX_NO","Company Tax No.");
define("INFO_TITLE","Info");


# Misc

define("TIME","Time");
define("PICKUP","Pickup");

# Booking Form
define("STARTING_FROM", "Starting From");
define("GOING_TO", "Going To");
define("CARD_TYPE","Card Type");
define("CARD_NUMBER", "Card Number");
define("CARD_CVD","Control Number");
define("CARD_EXP_DATE","Expiration date");
define("VEHICLE_TYPE","Preferred Vehicle Type");
define("EXTRAS","Additional Services");
define("EXTRAS_DESC","e.g. bikes, skis, wheelchair, extra luggage");
define("CHILD_SEATS","Child Seats");
define("BABY_SEATS","Baby Seats");
define("PICKUP_CITY","Pick-Up City, Country");
define("DROPOFF_CITY","Drop-Off City, Country");
define("NOTES","Notes");

# Booking Form Help
define("HELP_NO_OF_PAX","Please enter the number of passengers for this trip including children.<br>All transfer prices are for the vehicle, so number of passengers does not affect the price.");

define("HELP_PICKUP_DATE",'Enter the date for your pickup in format YYYY-MM-DD.<br>If you are traveling to or from a different time zone, make sure that this is a correct date in a time zone where your pickup is to be done.');

define("HELP_PICKUP_TIME",'Enter the time for your pickup in format HH:MM.<br>If you are traveling to or from a different time zone, make sure that this is a correct time in a time zone where your pickup is to be done.<br>If you are arriving by plane, bus, ferry or some other means of transportation it is best to enter your planned  time of arrival here. If there are any delays your driver will know about them.');

define("HELP_PICKUP_POINT",'Your pickup place may be an airport terminal, a hotel, private accommodation or some other place that has a name or designation. If this is the case, enter that name here.<br>Examples: Terminal 1; Dock 23; Hotel Jupiter; Two cows Bed and Breakfast; Shopping mall Centurion etc.<br>This will help your driver to find you more easily.');

define("HELP_PICKUP_ADDRESS","Street name and number.<br>If you don\'t know the address and your pickup place is a well known place like a hotel, airport, bus station etc. you may enter \'unknown\' in this field.<br>We recommend that you try to find the exact address.");

define("HELP_PICKUP_NOTE",'Any notes regarding your pickup may be entered here and your driver will receive them.<br>For example: Meet me at a hotel lobby; I need help with my suitcases; I have a wheelchair; My dog is traveling with me etc.');

define("HELP_DROPOFF_POINT",'This is the ending point of your transfer.<br>It may be an airport terminal, a hotel, private accommodation or some other place that has a name or designation. If this is the case, enter that name here.<br>If not, just enter \"none\".');

define("HELP_DROPOFF_ADDRESS",'Street name and number of your drop-off location. Your driver will check this address and be prepared to take you there choosing a shortest and fastest route.');

define("HELP_DROPOFF_NOTE",'If you have any notes regarding your drop-off, enter them here.');

define("HELP_FLIGHT_NO",'<b>Arrival</b><br>If you are arriving to an airport where you are to be picked up, enter the number of the flight that will get you there, not the flight number you are starting with.<br>For example: you are flying from New York to Heathrow on a flight XX789 and from there to Rome on flight RM908.<br>If you are to be picked up in Heathrow you should enter XX789. If you are to be picked up in Rome enter RM908.<br><br><b>Departure</b><br>If our driver is taking you TO the airport, please enter the number of your departing flight.');

define("HELP_FLIGHT_TIME",'Please see help for Flight Number.<br>Flight time should be official arrival time or official departure time of your flight.');


# - Driver Section
define("DRIVER_POLICIES", "Driver's Policies");
define("DECLINE_TIME", 'Driver is allowed to reject your transfer within');
define("HOURS", 'hours after reservation is complete.');
define("RESERVATIONS_PRE", "Reservations must be made at least");
define("RESERVATIONS_POST", "hours before transfer starts.");
define("CANCELLATION_PRE", "If cancelled up to");
define("CANCELLATION_POST", "hours before transfer, no fee will be charged.");
define("NO_SHOW_PRE", "If cancelled later or in case of no-show");
define("NO_SHOW_POST", "% of total transfer value will be charged.");
define("CREDIT_CARDS_ACCEPTED", "Accepted credit cards");
define("NO_CREDIT_CARDS_ACCEPTED", "No credit cards accepted!");
define("PREPAYMENT_DEPOSIT", "Prepayment - Deposit Policy");
define("PREPAYMENT_DEPOSIT_PRE", "Driver reserves the right to charge");
define("PREPAYMENT_DEPOSIT_POST", "% of total transfer rate as prepayment / deposit.");
define("CARD_AUTHORIZATION_STATEMENT", "Driver reserves the right to pre-authorise credit card prior to transfer.");

define("MEETING_POLICIES", "Meeting Service Policies");
define("MEETING_POLICIES_GENERAL", "General rules");
define("MEETING_POLICIES_AIRPORT", "Airports");
define("MEETING_POLICIES_FERRY", "Ferry Ports and Harbours");
define("MEETING_POLICIES_BUS", "Bus Terminals and Stations");
define("MEETING_POLICIES_TRAIN", "Train Stations");

# Index How does this work
define("INDEX_TEXT",'
<h2>Booking a taxi on Taxido.net</h2>
Please read this carefully if You are not familiar with the way Taxido.net works.
<br/>

<h3>Starting point of Your taxi transfer</h3>
Begin by typing Your starting or - as it\'s usually called - Pick-up point in the field above. You don\'t have to press Enter or click any buttons. After You type first three letters, You will be presented with search results. Typing more letters will narrow the search. You can then select Your Pickup point by clicking on it\'s name.<br/><br/>

<h3>Ending point of Your taxi transfer</h3>
After You have selected Your Pick-up point, it is time to select Your Drop-Off point or the ending point of Your transfer. You can select Your Drop-Off point from a list of locations, similar to the one You\'ve selected Your Pickup point from. All available Drop-Off points that Drivers have published are listed here. Just click on the name. <br/><br/>

<h3>Date, time and other transfer details</h3>
In this step You are asked to enter the usual details about Your transfer - date, time, Pickup and Drop-Off details, flight details etc. Help is provided for all items, so please read it if You are not sure what to enter.<br/><br/>

<h3>Selecting a Driver for Your transfer</h3>
Here is the main difference between Taxido.net and other taxi transfer web sites:<br/>
<b>we allow You to pick Your driver and vehicle by Yourself.</b><br/>
Most other taxi transfer sites do that for You and You never know who\'s going to be Your driver. Not us! You can pick Your driver from a list of drivers that have Your route in their offer. Make Yourself familiar with Driver Policies, take a look at Comments and Images and be sure to see how is Your driver rated so far.<br/>
Then pick one You like the most!
<br/><br/>

<h3>Information about You</h3>
There are absolutely NO PAYMENTS to be made through Taxido.net. All payments are made directly to Your driver.<br/>
You\'ll notice that we do ask for Your credit card data, but the only purpose of that is to make sure that Your driver will be paid if You don\'t show up at Your Pickup Point.<br/>
Please read our Terms and Conditions and respective Driver Policies for more information.
<br/>


');

/* EOF */


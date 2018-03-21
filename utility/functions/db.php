<?php
#------------------------------------------------------------------------------------#
# Studente: Edoardo Canobbio (805585) - Progetto di Tweb 2017                        #
# Collection of usefull functions that need to connect to the db.                    #
#------------------------------------------------------------------------------------#

#-------------------------------------------#
# Connect to the db and notify errors.      #
#                                           #
#                                           #
#-------------------------------------------#
function db_connect() { 
  $dsn = 'mysql:dbname=dbprogetto;host=localhost';
  $dbuser = 'userprogetto';
  $dbpass = 'passwordsicura';
  try {
    $db = new PDO($dsn, $dbuser, $dbpass);
  } catch(PDOException $e) {
    print_r("Database error: " . $e->getMessage());
    die;
  }
    return $db;
}

# --------------------------------------------------- ENTRY CREATION ---------------------------------------------

#-------------------------------------------#
# Add a new line in the "users" table.      #
#                                           #
#                                           #
#-------------------------------------------#
function create_user($fname, $lname, $username, $password, $email = NULL) {
  $db = db_connect();

  $password = password_hash($password, PASSWORD_DEFAULT); # Hashing: salt=random, cost=10     
  $stmt = $db->prepare("INSERT INTO users (fname, lname, username, passwd, email) VALUES (?, ?, ?, ?, ?)");

  try {
    $stmt->execute(array($fname, $lname, $username, $password, $email));
  } catch (PDOException $e) {
    print_r("Database error: " . $e->getMessage());
    die;
  }
}

#-------------------------------------------#
# Add a new line in the "events" table.     #
#                                           #
#                                           #
#-------------------------------------------#
function create_event($title, $date, $description, $userid) {
  $db = db_connect();

  $stmt = $db->prepare("INSERT INTO events (id_manager, event_date, title, description) VALUES (?, ?, ?, ?)");
  try {
    $stmt->execute(array($userid, $date, $title, $description));
  } catch (PDOException $e) {
    print_r("Database error: " . $e->getMessage());
    die;
  }
}

#-------------------------------------------#
# Add a new row tothe requests table        #
#                                           #
#                                           #
#-------------------------------------------#
function create_request($id_product, $id_buyer, $quantity){
  $db = db_connect();

  $stmt = $db->prepare("INSERT INTO requests (id_product, id_buyer, quantity) VALUES (?, ?, ?)");
  try {
    $stmt->execute(array($id_product, $id_buyer, $quantity));
  } catch (PDOException $e) {
    print_r("Database error: " . $e->getMessage());
    die;
  }
}





# --------------------------------------------------- RETRIVE INFO ---------------------------------------------

#-------------------------------------------#
# Return all the columns and rows of the    #
# specified table (add if specified options)#
#                                           #
#-------------------------------------------#
function all_of($table, $options = NULL) {
  $db = db_connect();
  $query = "SELECT * FROM $table $options;";
  return $db->query($query);
}

#-------------------------------------------#
# Return an array with user's info.         #
# (id fname lname username passwd email)    #
#-------------------------------------------#
function get_user_info($username, $userid = 'NULL') {
  $db = db_connect();

  $username = $db->quote($username);
  $query = "SELECT *
            FROM users
            WHERE username = $username OR id = $userid;";
  $rows = $db->query($query);

  if ($rows->rowCount() > 0) { 
    foreach ($rows as $row) {
      return $row;          # always 1 row only
    }
  } else { return FALSE; }  # user not found
  
}

#-------------------------------------------#
# Return user's events info.                #
# (title, description, event_date)          #
#                                           #
#-------------------------------------------#
function get_events($userid) {
  $db = db_connect();

   $userid = $db->quote($userid);  # not trusting my own code
   $query = "SELECT title, description, event_date
             FROM events
             WHERE id_manager = $userid
             ORDER BY event_date;";
  $rows = $db->query($query);
  return $rows;
}

#-------------------------------------------#
# Return an array with all the requests for #
# products. (user fname and lname, product  #
# name, request quantity)                   #
#-------------------------------------------#
function get_requests() {
  $db = db_connect();

  $query = "SELECT u.fname, u.lname, p.name, r.quantity, p.type
            FROM users AS u 
            JOIN requests AS r ON u.ID = r.id
            JOIN products AS p ON r.id_product = p.ID;";
  return $db->query($query);
}

# --------------------------------------------- INPUT CHECKING ---------------------------------------------

#-------------------------------------------#
# Returns TRUE if given password is correct #
# for this user name.                       #
#                                           #
#-------------------------------------------#
function is_password_correct($username, $password) {
  $db = db_connect();

  $username = $db->quote($username);
  $query = "SELECT passwd 
            FROM users 
            WHERE username = $username;";
  $rows = $db->query($query);
  if ($rows->rowCount() > 0) {
    foreach ($rows as $row) {
      $correct_password = $row["passwd"];
      return password_verify($password, $correct_password);
    }
  } else {
    return FALSE;   # user not found
  }
}

#-------------------------------------------#
# Return TRUE if all the conditions for     #
# signing in are met.                       #
#                                           #
#-------------------------------------------#
function check_input_signin() {
  print_r($_POST["fname"]);
  if (isset($_POST["fname"])    &&
      isset($_POST["lname"])    && 
      isset($_POST["username"]) && 
      isset($_POST["password"]) && 
      isset($_POST["confirm_password"])) {     # all camps filled
    if (!get_user_info($_POST["username"])) {  # user doesn't exist
      return ($_POST["password"] === $_POST["confirm_password"]); 
    } 
  }
  return FALSE;
}

# --------------------------------------------- OTHER INTERACTIONS ---------------------------------------------

#-------------------------------------------#
# Return the result of a user research in   #
# the db about products requests            #
#                                           #
#-------------------------------------------#
function market_search ($product, $flag, $fname, $lname, $check) {
  $db = db_connect();

  if ($check === 1) { $option = "WHERE"; }
  else { $option = "WHERE r.id_seller IS NULL AND"; }

  if ($product != "all") {                                             # only one product
    $product = $db->quote($product);
    $prod = "p.name = $product AND";
  } else { $prod = ""; }                                               # all products

  $mid = "JOIN users AS u ON r.id_buyer = u.id";                       # all the users
  $end = "$option $prod 1";

  if ($fname && $lname) {
    $fname = $db->quote($fname);
    $lname = $db->quote($lname);
    $mid = "JOIN users AS u ON u.fname = $fname AND u.lname = $lname"; # specific the name
    $end = "$option $prod r.id_buyer = u.id";
    }
  # Assembling the query.
  $query =  "SELECT r.quantity, p.name, u.id, r.id as rID
              FROM requests AS r
              JOIN products AS p ON r.id_product = p.id
              $mid $end;";
  return $db->query($query);
}

#-------------------------------------------#
# Delete a row from the events table        #
#                                           #
#                                           #
#-------------------------------------------#
function delete_event($eventid) {
  $db = db_connect();

  $query = "DELETE FROM events WHERE id = $eventid";
  try {
    $db->exec($query);
  } catch (PDOException $e) {
    print_r("Database error " . $e->getMessage());
  }
}

#-------------------------------------------#
# Update a row in the requests table        #
#                                           #
#                                           #
#-------------------------------------------#
function request_satisfy($id_request, $id_seller) {
  $db = db_connect();

  $stmt = $db->prepare("UPDATE requests 
                        SET id_seller = :id_seller
                        WHERE id = :id_request;");
  $stmt->bindParam(':id_seller', $id_seller, PDO::PARAM_INT);
  $stmt->bindParam(':id_request', $id_request, PDO::PARAM_INT);

  try {
    $stmt->execute();
  } catch (PDOException $e) {
    print_r("Database error: " . $e->getMessage());
    die;
  }
}
?>
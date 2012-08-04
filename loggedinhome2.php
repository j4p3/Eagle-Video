<?php
session_start();
$username = $_SESSION["username"];
if ($username == null) {
	$header="<form method=post action=\"login.php\">
		Please login to begin.
		<br>
		Username: <input type=text name = \"nm\" size=10>
		<br>
		Password: <input type=text name = \"pwd\" size=10>
		<br>
		<input type=submit>
		</form>"
} else {
	$header= $username . "<br><a href=\"accountinfoview.php\">Account</a>/<a href=\"logout.php\">Logout</a>"
}
?>

<html>
<head>
<script>
	var btn = {
	    init : function() {
	        if (!document.getElementById || !document.createElement || !document.appendChild) return false;
	        as = btn.getElementsByClassName('btn(.*)');
	        for (i=0; i<as.length; i++) {
	            if ( as[i].tagName == "INPUT" && ( as[i].type.toLowerCase() == "submit" || as[i].type.toLowerCase() == "button" ) ) {
	                var a1 = document.createElement("a");
	                a1.appendChild(document.createTextNode(as[i].value));
	                a1.className = as[i].className;
	                a1.id = as[i].id;
	                as[i] = as[i].parentNode.replaceChild(a1, as[i]);
	                as[i] = a1;
	                as[i].style.cursor = "pointer";
	            }
	            else if (as[i].tagName == "A") {
	                var tt = as[i].childNodes;
	            }
	            else { return false };
	            var i1 = document.createElement('i');
	            var i2 = document.createElement('i');
	            var s1 = document.createElement('span');
	            var s2 = document.createElement('span');
	            s1.appendChild(i1);
	            s1.appendChild(s2);
	            while (as[i].firstChild) {
	              s1.appendChild(as[i].firstChild);
	            }
	            as[i].appendChild(s1);
	            as[i] = as[i].insertBefore(i2, s1);
	        }
	        // The following lines submits the form if the button id is "submit_btn"
	        btn.addEvent(document.getElementById('submit_btn'),'click',function() {
	            var form = btn.findForm(this);
	            form.submit();
	        });
	    },
	    findForm : function(f) {
	        while(f.tagName != "FORM") {
	            f = f.parentNode;
	        }
	        return f;
	    },
	    addEvent : function(obj, type, fn) {
	        if (obj.addEventListener) {
	            obj.addEventListener(type, fn, false);
	        }
	        else if (obj.attachEvent) {
	            obj["e"+type+fn] = fn;
	            obj[type+fn] = function() { obj["e"+type+fn]( window.event ); }
	            obj.attachEvent("on"+type, obj[type+fn]);
	        }
	    },
	    getElementsByClassName : function(className, tag, elm) {
	        var testClass = new RegExp("(^|\s)" + className + "(\s|$)");
	        var tag = tag || "*";
	        var elm = elm || document;
	        var elements = (tag == "*" && elm.all)? elm.all : elm.getElementsByTagName(tag);
	        var returnElements = [];
	        var current;
	        var length = elements.length;
	        for(var i=0; i<length; i++){
	            current = elements[i];
	            if(testClass.test(current.className)){
	                returnElements.push(current);
	            }
	        }
	        return returnElements;
	    }
	}

	btn.addEvent(window,'load', function() { btn.init();} );
</script>
<style type="text/css">
	.container{
		clear:both;
		height:60px;
		background-color:#3861a5;
	}
	.navbar{
		width:365px;
		float:left;
	}
	.user{
		float:left;
		width:200px;
		text-align:center;
		padding-right:10px;
		vertical-align:text-top;
		font-size:16px;
		color:#ffffff;
		font-family: "HelveticaNeue-Ultralight";
	}
	.search{
		width:300px;
		background-color:#ffffff;
		vertical-align:top;
		float:right;
		padding-top:8px;
		padding-left:8px;
		border-width: 1px;
		border-color:#a30008;
		border-style:solid;
		font-size:16px;
		color:#ffffff;
		font-family: "HelveticaNeue-Ultralight";
	}
	
	.btn { display: block; position: relative; background: #aaa; padding: 5px; float: left; color: #fff; text-decoration: none; cursor: pointer; }
	.btn * { font-style: normal; background-image: url(http://sheeta.bc.edu/~cs257e/img/btn2.png); background-repeat: no-repeat; display: block; position: relative; }
	.btn i { background-position: top left; position: absolute; margin-bottom: -5px;  top: 0; left: 0; width: 5px; height: 5px; }
	.btn span { background-position: bottom left; left: -5px; padding: 0 0 5px 10px; margin-bottom: -5px; }
	.btn span i { background-position: bottom right; margin-bottom: 0; position: absolute; left: 100%; width: 10px; height: 100%; top: 0; }
	.btn span span { background-position: top right; position: absolute; right: -10px; margin-left: 10px; top: -5px; height: 0; }

	* html .btn span,
	* html .btn i { float: left; width: auto; background-image: none; cursor: pointer; }

	.btn.blue { background: #2ae; }
	.btn.green { background: #9d4; }
	.btn.red { background: #a30; }
	.btn:hover { background-color: #a30008; }
	.btn:active { background-color: #444; }
	.btn[class] {  background-image: url(http://sheeta.bc.edu/~cs257e/img/shade.png); background-position: bottom; }

	* html .btn { border: 3px double #aaa; }
	* html .btn.blue { border-color: #2ae; }
	* html .btn.green { border-color: #9d4; }
	* html .btn.red { border-color: #a30; }
	* html .btn:hover { border-color: #a00; }

</style>
</head>
<body>
	<div class="container">
		<div id="header" class="navbar">
			<a id="logo" href="http://sheeta.bc.edu/~cs257e/loggedinhome.php" title="Eagle Video">
				<img src="http://sheeta.bc.edu/~cs257e/img/EV_logo.png" alt="Ooh, Aah."><img src="http://sheeta.bc.edu/~cs257e/img/EagleVideo_logo.png">
			</a>
		</div>

		<div id="toptext" class="user">
			<?php echo $header;?>
			Mary
		</div>
		<div id="searchbar" class="search">
			<form method=get action="search_results.php"> 
			<input type=text name = "search" size=10>
			<select name="searchtype"> 
			   <option value="genre">Genre</option> 
			   <option value="actor">Actor</option> 
			   <option value="title">Movie</option> 
			</select>
			<input type=submit value="SEARCH" id="submit_btn" class="btn red"> 
			</form>
		</div>
	</div>

<DIV align="right">
<FONT COLOR="green">Welcome, <?php echo $username; ?>!</FONT>
<br>
<a href="accountinfoview.php">My Account Page</a>
<br>
<a href="shoppingcart.html">Shopping Cart</a>
<br>
<a href="logout.php">Logout</a>
</DIV>

<br>
<form method=get action="search_results.php">
Select an option to search by and then type in your search: 
<select name="searchtype">
   <option value="genre">Genre</option>
   <option value="actor">Actor Name</option>
   <option value="title">Movie Title</option>
</select> <br>
   
<input type=text name = "search" size=10>
<br>
<input type=submit>
</form>
<P>
*Please be sure to enter in your search with proper capitalization
<br>
(Capitalize actor's names, movie titles, and genres.)
<P>


<h1 align="center">Recommendations for You</h1>
<br>
<br>
<h1 align="center">New Releases</h1>


</body>
</html>
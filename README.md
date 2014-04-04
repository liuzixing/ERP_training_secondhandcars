<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!-- saved from url=(0055)http://www.guillaumeriviere.name/efrei/tp2-3.php?bits64 -->
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr-FR" xml:lang="fr-FR"><head><meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
 
<link href="./TP2-3  Module programming and webservices_files/style2010-b2.css" rel="stylesheet" type="text/css" media="screen" title="screen1">
<link href="./TP2-3  Module programming and webservices_files/style2010-wkit.css" rel="stylesheet" type="text/css" media="screen" title="screen1">
<title>TP2-3: Module programming and webservices</title>
<script type="text/javascript" src="./TP2-3  Module programming and webservices_files/unhide.js"></script><style type="text/css"></style><script type="text/javascript" src="./TP2-3  Module programming and webservices_files/minimum.js"></script></head>
<body>
<div id="body" style="width: 90%;">
<div id="entete" class="curved" style="padding: 20px; font-size: 16px;">
<img id="logo" class="fluxL" src="./TP2-3  Module programming and webservices_files/efrei.png" alt="EFREI" style="height: 95px; margin-top: 0px;">
<h1 id="title" style="margin: 10px;">TP2-3: Module programming and webservices</h1>
</div>
<div id="corpsPage" class="corps" style="padding: 20px 50px 30px;">
<p class="objectif"><img class="fluxL" src="./TP2-3  Module programming and webservices_files/objectif.png" alt="&#9830;"> The aim of this work is to learn basis of module development, using OpenERP, through a single and (quite) complete example. After several progressive steps, you will obtain a new module for the management of a second hand cars garage. The starting point is a nearly empty module, displaying a simple car brands list. Each exercise guides you in order to complete the module. The objective to reach is the management of car brands, car models, and the state of the second hand cars of a garage.<br class="flux"></p>
<p>With the following exercises, we are going to learn how module are made through a simple example. Also, one should know that one of the simpliest module of OpenERP is the «Idea» module (present in official modules). However, our starting point is going to be even simplier than this module to manage innovative ideas in a company.</p>
<p>A module describing cars (brands, models, …) already exist among the official modules of OpenERP: it is called «Fleet». A good way to do things for experts could be, to develop our module, building it by reusing the classes of «Fleet». But we are not going to do that because we are here to learn, step by step, how modules are made.</p>
<p>Online documentation of the developper for OpenERP, maintained by OpenERP community, can be found at:<br> <a href="http://doc.openerp.com/trunk/developers/server/03_module_dev/">http://doc.openerp.com/trunk/developers/server/03_module_dev/</a></p>
<p>The technical memento, published by Open Object Press and edited by OpenERP S.A., is also a good help for the developper:<br> <a href="http://anybox.fr/docs/openerp-technical-memento-0.6.5-a4/at_download/file">OpenERP_Technical_Memento_v0.6.5_A4_nondraft.pdf</a></p>
<h2>Exercise 1 • Car brands list<a name="exo1"> </a></h2>
<p>As we did during TP1, start the Debian virtual machine and log in with <span class="bold warn">riesling</span> user</p>
<h3>1.1 Install and run the Idea module</h3>
<ol>
 <li>Start <kbd>openerp-server</kbd> (as we did during TP1)</li>
 <li>Run Iceweasel web browser, and go at OpenERP login page.
<ul>
 <li>Create a new database, and <span class="underline">don't forget</span> to check the option «&nbsp;Load demonstration data&nbsp;» <img class="button" src="./TP2-3  Module programming and webservices_files/b_checked.png" alt=""></li>
 <li><span class="warn">Activate the «&nbsp;Technical Features&nbsp;»</span> in the access rights of the Administrator user.</li>
 <li>Install the module «Idea».</li>
 <li>For the access rights of the Administrator, <span class="warn">add him as a user of Extra Tools</span> and then <span class="bold">reload</span> the page.</li>
 <li>Explore the Idea module (available from the Tool main menu) and create new ideas and categories.</li>
</ul>
 </li>
 <li>From a terminal, do:
<ul>
 <li>su openerp</li>
 <li>chmod -R 777 /opt/openerp/addons/</li>
</ul>
 </li><li>Then, launch gedit text editor (<span class="underline">Applications</span> &gt; <span class="underline">Accessories</span> &gt; <span class="underline">Text Editor gedit</span>), and open <kbd>/opt/openerp/addons/idea/__openerp__.py</kbd> and try to understand its content. This file, present in each module, describes some meta informations.</li>
 <li>Now open <kbd>/opt/openerp/addons/idea/idea.py</kbd> and identify the two Python classes present in it. This file defines the data models of the module, which can be represented like this:</li>
<img class="margin" src="./TP2-3  Module programming and webservices_files/diagram_model_idea.png" alt="Idea module model diagram">
 <li>Open the file <kbd>/opt/openerp/addons/idea/idea_view.xml</kbd> which contains the description of the user interface elements. It can be summarized like this:</li>
<img class="margin" src="./TP2-3  Module programming and webservices_files/diagram_view_idea.png" alt="Idea view diagram">
<img class="margin" src="./TP2-3  Module programming and webservices_files/diagram_view_category.png" alt="Category view diagram">
</ol>
<h3>1.2 Install and run the nearly empty module (version 0)</h3>
<ol>
 <li>Create a new directory <kbd>/home/riesling/myaddons</kbd></li>
 <li>In this new directory, download and extract <a href="http://www.guillaumeriviere.name/efrei/secondhandcars-v00.tgz">secondhandcars-v00.tgz</a></li>
 <li>Stop the server <kbd>openerp-server</kbd> doing <img class="button" src="./TP2-3  Module programming and webservices_files/Ctrl.png" alt="CTRL">+<img class="button" src="./TP2-3  Module programming and webservices_files/C.png" alt="C"></li>
 <li>Create a symbolic link with the following command: <br><kbd>ln -s /home/riesling/myaddons/secondhandcars/ /opt/openerp/addons/</kbd></li>
 <li>Then, restart <kbd>openerp-server</kbd></li>
 <li>Go back to OpenERP client, and go at <span class="underline">Settings</span> &gt; <span class="underline">Update Modules List</span> and click the update button.
<ul>
 <li>Now, install the module «Second Hand Cars» and explore its views.</li>
 <li>Observe the two possible view modes (list and form) for the brands.</li>
 <li>In these 2 views, observe the fields which are displayed for the brands.</li>
 <li>Try to create a new brand.</li>
</ul>
 </li>
 <li>Open the file <kbd>secondhandcars/secondhandcars.py</kbd> and observe the actual data model. For the moment the only Python class is very simple.<br>
<img class="margin" src="./TP2-3  Module programming and webservices_files/diagram_model_brand.png" alt="Brand model diagram">
 </li>
<div class="explications">
<br>The aim of this work is to complete this minimal module, step by step, and at the end the data model will grow to become the following one:<br>
<img class="margin" src="./TP2-3  Module programming and webservices_files/diagram_model_shc.png" alt="Brand model diagram">
</div>
 <li>For the moment, the views described in <kbd>secondhandcars/secondhandcars_view.xml</kbd> are the following:</li>
<img class="margin" src="./TP2-3  Module programming and webservices_files/diagram_view_shc.png" alt="Second hand cars diagram of views">
 <li>Have a look to the demo data (which was loaded when you tried the module) given in the file <kbd>secondhandcars/secondhandcars_data.xml</kbd></li>
 <li>Note also the access rights are described in the file <kbd>secondhandcars/security/ir.model.access.csv</kbd></li>
</ol>
<h3>1.3 Adding new fields to car brands (version 1)</h3>
<p>More than the name of the brands, we would like to know the URL of:</p>
<ul>
 <li>The main page of the international website of the brand</li>
 <li>The main page of the local website of the brand</li>
 <li>The page were models of the brand can be found (on the local website if possible)</li>
</ul>
<p>To do this, you have to edit:</p>
<ol>
 <li>The Python class of the brands (in <kbd>secondhandcars.py</kbd>): add new columns for the new fields</li>
 <li>The 2 views tree and form of the brands (in <kbd>secondhandcars_view.xml</kbd>): add the new fields to display</li>
 <li>The demo data file (<kbd>secondhandcars_data.xml</kbd>): add values for the new fields</li>
</ol>
<div class="explications">
<img class="fluxL" src="./TP2-3  Module programming and webservices_files/warn.png" alt="ATTENTION">
<p><span class="bold">To test your modifications</span>, the module has to be reloaded in memory. To do so, the server must be restarted. But <span class="warn">before restarting the server</span>, you have to firstly uninstall the module. Thus, each time you modifiy the python file of a module, the steps are:</p>
<ol>
 <li>Uninstall the module</li>
 <li>Restart the server
 </li>
 <li>Install the module</li>
</ol>
<p class="italic">Note: during all these steps, you don't need to close or to log out OpenERP client. You can keep opened OpenERP page in you web browser. It will not be a problem to continue navigation once the server has restarted.</p>
</div>
<p>Once the installation succeeds, try to create of a new brand.</p>
<h2>Exercise 2 • Car models list (version 2)<a name="exo2"> </a></h2>
<h3>2.1 Create a new OpenERP model and associated views</h3>
<p>You are going to create a new Python class for the car models.</p>
<img class="margin" src="./TP2-3  Module programming and webservices_files/diagram_model_model.png" alt="Car models model diagram">
<p>The information we want for the business object car is:</p>
<table class="fields">
<tbody><tr>
<td><kbd>name</kbd></td>
<td>The name of the model</td>
</tr>
<tr class="bg">
<td><kbd>brand_id</kbd></td>
<td>The id of the car brand</td>
</tr>
<tr>
<td><kbd>last_year</kbd></td>
<td>The last year of production (can be null)</td>
</tr>
</tbody></table>
<p>A car brand can have several car models, while a car model can have only one (and only one) car brand. The relation between car models and brand models is then a [1-N] relation. Thus, the field <kbd>brand_id</kbd> will be a <kbd>many2one</kbd> id relation (have a look to the Idea module).</p>
<p>Create the new views for car models (continue adding all views in the same file <kbd>secondhandcars/secondhandcars_view.xml</kbd>).</p>
<img class="margin" src="./TP2-3  Module programming and webservices_files/diagram_view_model.png" alt="Car models view diagram">
<p>To test your modifications, stop and restart server again.</p>
<p>When re-installation succeeds, create a new car model using the form.</p>
<h2>Exercise 3 • Second hand cars list (version 3)<a name="exo3"> </a></h2>
<h3>3.1 Create a new OpenERP model and associated views</h3>
<p>You are going to create a new Python class for the cars of the garage.</p>
<img class="margin" src="./TP2-3  Module programming and webservices_files/diagram_model_cars.png" alt="Cars model diagram">
<p>The information we want for the model of a car is:</p>
<table class="fields">
<tbody><tr>
<td><kbd>create_uid</kbd></td>
<td>The id of the user who created the car</td>
</tr>
<tr class="bg">
<td><kbd>immatriculation</kbd></td>
<td>The immatriculation code of the car</td>
</tr>
<tr>
<td><kbd>model_ids</kbd></td>
<td>The id of the car model</td>
</tr>
<tr class="bg">
<td><kbd>km_in</kbd></td>
<td>kilometers of the car when arriving at the garage</td>
</tr>
<tr>
<td><kbd>km_out</kbd></td>
<td>kilometers of the car when leaving the garage</td>
</tr>
<tr class="bg">
<td><kbd>price</kbd></td>
<td>The price the garage wants to sell the car (will be displayed on the car)</td>
</tr>
<tr>
<td><kbd>doors</kbd></td>
<td>The number of doors</td>
</tr>
<tr class="bg">
<td><kbd>seats</kbd></td>
<td>The number of seats</td>
</tr>
<tr>
<td><kbd>energy</kbd></td>
<td>The energy of the engine, among: Gasoline / Diesel / Gaz / Electricity / Hybrid</td>
</tr>
</tbody></table>
<p>The following views will have to be defined:</p>
<img class="margin" src="./TP2-3  Module programming and webservices_files/diagram_view_car.png" alt="Cars view diagram">
<p>To help you defining the search view, have a look to how it is made in the Idea module. Then define the following search filters:</p>
<ol>
 <li>Filter cars with less than 10.000 km</li>
 <li>Filter cars with less than 100.000 km</li>
 <li>Filter cars with more than 100.000 km</li>
 <li>Group cars by model</li>
 <li>Group cars by energy</li>
</ol>
<p>Once again, don't forget to stop, restart, re-install and test your module. Try each of the filters you have created. Adding some new and different car models may help you to validate your filters.</p>
<h2>Exercise 4 • Communication by webservice<a name="exo4"> </a></h2>
<p>OpenERP webservices, thought XML-RPC, allows one to call methods of the ORM in order to create, read, write, search and delete records form a remote program, written in any programming language with XML-RPC support (C, C++, Java, PHP, Javascript, Python, Perl, …).</p>
<h3>4.1 Test asking OpenERP webservices from a Python script</h3>
<p>Download the script <a href="http://www.guillaumeriviere.name/efrei/create.py">create.py</a></p>
<p>Open it with gedit and:</p>
<ol>
 <li>Check that the DB name and the user identication are correctly set to run with your configuration.</li>
 <li>Replace the informations of the partner to create with your identity</li>
</ol>
<p>Then run the script and check the presence of the new record in OpenERP. <span class="italic">(To check the presence, ensure you have the access rights to "Sales". If not, set it and <span class="bold">reload</span> the page)</span></p>
<h3>4.2 Test asking OpenERP webservices from a PHP script</h3>
<p>First of all, we prepare a web server environment:</p>
<ol>
 <li><kbd>mkdir /home/riesling/public_html/</kbd></li>
 <li><kbd>su root</kbd> <span class="medium warn italic">(ask me for root password)</span></li>
 <li>Then, install Apache2, php5 and php-xml-rpc thanks to the following command line:<br> <kbd>apt-get install apache2 php5 php-xml-rpc</kbd></li>
 <li>Restart apache2: <br><kbd>service apache2 restart</kbd></li>
 <li>Then, create dir: <br><kbd>mkdir /var/www/mywebsite</kbd></li>
 <li>Create the following symbolic link: <br><kbd>ln -s /home/riesling/public_html/ /var/www/mywebsite</kbd></li>
</ol>
<p>Now, as normal user (i.e. not as root user)</p>
<ol>
 <li>Download the archive  <a href="http://www.guillaumeriviere.name/efrei/tests/Webservices_example.zip">Webservices_example.zip</a> and extract its content in: <kbd>/home/riesling/public_html/</kbd></li>
 <li>Change access rights of the directory:<br><kbd>chmod 755 /home/riesling/public_html/webservices_example/</kbd></li>
 <li>So the URL to use will now be: <kbd>http://127.0.0.1/mywebsite/</kbd></li>
</ol>
<p>Check the presence of the following files:</p>
<ol>
 <li><kbd>form.html</kbd></li>
 <li><kbd>vars.inc.php</kbd></li>
 <li><kbd>login.inc.php</kbd></li>
 <li><kbd>create_example.php</kbd></li>
 <li><kbd>search_example.php</kbd></li>
 <li><kbd>read_example.php</kbd></li>
 <li><kbd>write_example.php</kbd></li>
 <li><kbd>unlink_example.php</kbd></li>
</ol>
<p>Open each file (in the order above) with gedit in order to observe the source codes:</p>
<ol>
 <li>Try to understand the scripts and what it should do.</li>
 <li>Some documentation about the XML-RPC library can be found on PEAR's website:<br><a href="http://pear.php.net/package/XML_RPC/docs">http://pear.php.net/package/XML_RPC/docs</a><br><a href="http://pear.php.net/manual/en/package.webservices.xml-rpc.api.php">http://pear.php.net/manual/en/package.webservices.xml-rpc.api.php</a></li>
 <li>Check in the file <kbd>vars.inc.php</kbd> that the DB name and the user identication are correctly set to run with your configuration.</li>
</ol>
<p>Go back to OpenERP client and create 9 new ideas in the module Ideas: 3 will be in <kbd>draft</kbd> state (i.e. <span class="italic">New</span>), 3 in <kbd>open</kbd> state (i.e. <span class="italic">Accepted</span>), 2 in <kbd>cancel</kbd> state (i.e. <span class="italic">Refused</span>) and 1 in <kbd>close</kbd> state (i.e. <span class="italic">Done</span>).</p>
<p>Now, open the HTML form <a href="http://127.0.0.1/mywebsite/form.html">http://127.0.0.1/mywebsite/form.html</a> (or <a href="http://127.0.0.1/mywebsite/webservices_example/form.html">http://127.0.0.1/mywebsite/webservices_example/form.html</a> if you extracted in a subdirectory) and test the different scripts. Each time, check what happens in OpenERP client.</p>
<h3>4.3 Write a webpage showing the list of second hand cars to sell</h3>
<p>Now, we would like to display, on the web site, the list (with the immatriculation, km_in and price of the car) all the second hand cars powered by diesel available in the company.</p>
<p>So, you have to write a web page showing this list.</p>
<p class="italic">(This work requires the relation secondhandcars.cars (from exercise 3) to be finished. If it is not finished, then just show the list of the brands the company is working with, i.e. the records of secondhandcars.brands)</p>
<h2>Exercise 5 • Workflow: states and transitions (version 4)<a name="exo5"> </a></h2>
<p>The workflow engine allows to describe the evolution of documents (model) in time. According to the processing flow and trade logic of the company, some actions can be automatically trigerred by the workflow engine. The workflow mechanism can also help to describe interactions of the document with different actors of the company (e.g. validation steps…), or again to manage interactions between different modules</p>
<p>A classical workflow diagram for OpenERP business objects is the one of the «Idea» module, as follow:</p>
<img src="./TP2-3  Module programming and webservices_files/workflow_diagram_1.png" alt="Classical Workflow Diagram">
<p>This workflow is defined at different points in the Idea module:</p>
<ul>
 <li><span class="bold"><kbd>idea/idea.py</kbd></span> : The names of the different states are listed in the field <kbd>state</kbd> of the <kbd>idea_idea</kbd> class</li>
 <li><span class="bold"><kbd>idea/idea.py</kbd></span> : The four methods idea_cancel(), idea_open(), idea_close() and idea_draft() of the class <kbd>idea_idea</kbd> which will be called during transitions.</li>
 <li><span class="bold"><kbd>idea/idea_workflow.xml</kbd></span> : Complete description of the different states (also called activities) and if it is a starting, a normal or a final state. Also, complete description of the possible transitions between these states. Each transition is defined with the signal to listen to trigger the transition and the method (of the business object) to call when the transition is triggered.<br> <span class="italic">Remark: the file <kbd>idea_workflow.xml</kbd> is listed in <kbd>__openerp__.py</kbd></span></li>
 <li><span class="bold"><kbd>idea/idea_view.xml</kbd></span> : Each buttons, in the header of the form view of idea, trigger the signal defined in the <kbd>name</kbd> parameter when clicked.</li>
</ul>
<h3>5.1 Defining the lyfecycle of the business object car</h3>
<p>Inspired by the Idea module, you have reproduce this mechanism for the Second Hand Cars module. For our case, the workflow of a car will be the following:</p>
<img src="./TP2-3  Module programming and webservices_files/workflow_diagram_2.png" alt="Second hand car Workflow Diagram">
<p class="italic"><small>Remark: The repair state cannot be bypassed, because an oil change will always be performed by the garage for the engine of the car.</small></p>
<ol>
 <li>Create the file <kbd>secondhandcars_workflow.xml</kbd>, modify the files <kbd>secondhandcars.py</kbd> and <kbd>secondhandcars_view.xml</kbd></li>
 <li>Add new filters in the search view, in order to filter car to be controlled, to be repaired and those which are ready to be sold.</li>
 <li>Add the fields date_draft, date_repaired, date_cancel and date_sold to the business object car. Modify the methods of the car in order to set the previous dates while the methods will be called.</li>
</ol>
<p class="conseil"><img class="fluxL" src="./TP2-3  Module programming and webservices_files/conseil.png" alt="&#9830;"> To get the current date in Python language:<br>At the begining of the file:<br><kbd>from datetime import datetime</kbd><br>then, you can use the function:<br><kbd>datetime.now()</kbd><br class="flux"></p>
<p class="conseil"><img class="fluxL" src="./TP2-3  Module programming and webservices_files/conseil.png" alt="&#9830;"> As done for <kbd>idea_workflow.xml</kbd> in the configuration file <kbd>__openerp__.py</kbd> of Idea, don't forget to declare the file <kbd>secondhandcars_workflow.xml</kbd> in the file <kbd>__openerp__.py</kbd> of SecondHandCars.<br class="flux"></p>
</div>

<div id="basdepage">
 <i>Last updated:</i> March 26, 2014 -  <i>Webmaster:</i> g.riviere@estia.fr - <i>URL:</i> <a href="http://www.guillaumeriviere.name/estia/si/">http://www.guillaumeriviere.name/estia/si/</a><br>
 <br>
<a href="http://validator.w3.org/check?uri=referer"><img src="./TP2-3  Module programming and webservices_files/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88"></a><a href="http://jigsaw.w3.org/css-validator/validator?uri=http%3A%2F%2Fwww.guillaumeriviere.name%2Festia%2Fsi%2F&profile=css3"><img style="width:88px;height:31px" src="./TP2-3  Module programming and webservices_files/vcss" alt="Valid CSS!"></a></div>
</div>


</body></html>
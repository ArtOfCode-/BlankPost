# BlankPost
Lightweight portable blogging website software.

## Get Started
It should be pretty easy to get started using BlankPost if you've got some basic experience administrating websites.
You will need:

- a web server you can administrate and upload files to (including above public_html)
- a MySQL database and user

Have a read of the guide below. If you're having trouble, drop me a line at `hello@artofcode.co.uk`.

1. **Download**  
 Clone the repository (or download it from GH):

      git clone https://github.com/ArtOfCode-/BlankPost
    
 That was an easy step! :)

2. **Configure**  
 You'll need to fill in some details here. In the `includes/` directory, you'll find a file called `site_config_example.ini`.
 You should rename it to `site_config.ini`. Open it in a text editor, and scroll down to the line that contains this:

      [database]
    
 That's the database details section. Just after that, there are a number of settings you'll need to change. In between the
 quote marks, you will need to fill in your database host, username, password, and name, after their respective titles.
 (Ask your web host if you don't know these details.) When you're done, the section should look something like this:

      [database]
      ; [STRING] The database host.
      HOST = "sql.mywebhost.com"  
 
      ; [STRING] The database username.
      USER = "bob"

      ; [STRING] The database identification password.
      PASS = "a9xD%vv&7"
 
      ; [STRING] The database name.
      NAME = "blankpost"
    
 That's the really basic configuration done - there are a number of other settings in this file which you can also fill in
 or change to change the look and feel of your site. There are comments in the file to tell you what each setting is.

3. **Upload**  
Now you upload everything to your server. You'll need to put the `includes/` directory **above** public_html - that's 
where BlankPost will expect it to be. The contents of the `www/` directory should go in the root of your public_html
folder.

4. **Set up the database**  
This starts to get slightly more technical now. You should now log into your database directly. In the `includes/`
directory, there's a file called `create_database.sql`, the contents of which you should execute as a SQL query on your
database.

5. **Create a user**  
You should now be able to view your website from a browser. Using the login link, navigate to the sign up page and sign 
up for a new user account with your details. You'll be making this account the administrator account in the next step.

6. **Create the administrator**  
Back in your database, you should now find the `Users` table, and the user you just created. Update it so that its 
`UserLevel` is now 99. You now have an administrator account. If you're already logged into the site, you'll need to log 
out and back in again to see the change; if not, go log into the site now! You'll have an Admin Control section available.
The controls there should let you play around with the site a little bit more.

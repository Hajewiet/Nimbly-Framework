Installation 
============

**Install Nimbly Core**<br />
[set repos-name="nimbly-[slug [site-name]]"]
Clone the nimbly core into '[repos-name]':<br />

```
cd ~/work (or replace with your project root dir)
git clone git@gitlab.com:volst-firma/nimbly.git [repos-name]
cd [repos-name]
```

**Clone scaleup repos into Ext**<br />
Clone the [repos-name] repos into 'ext':<br />

```
git clone git@github.com:Volst/[repos-name].git ext
```

**Create and run docker image**<br />
Follow the steps at /misc/docker-nimbly/Readme.md:

Building the docker image
-------------------------
Change directory to `[repos-name]/misc/docker-nimbly`and type `docker build -t [repos-name] .` to build the docker image, naming it "[repos-name]". 
You only need to build the docker container image once or if the source files of the docker image changed. 
Wait the build to finish verifying the console output does not show errors.
 
Running the docker image
------------------------
Run the image: `docker run --name [repos-name] -p 80:80 -v FULLPATHTOWHEREYOUCLONEDTHESOURCE:/var/www/nimbly -d  [repos-name]`. 
If you need another port than the default 80, type -p YOURPORT:80. Verify the image runs correctly, an "it works" message should appear when you browse to [http://localhost/](http://localhost/). 
If running Docker with Docker ToolBox, you need to replace localhost with the ip of the virtual box: [http://192.168.99.100/](http://192.168.99.100/)
On Windows Systems, the "FULLPATHTOWHEREYOUCLONEDTHESOURCE" needs to be somewhere in your own Users directory, e.g. //c/Users/John/Documents/Nimbly

Installation Script
-------------------
The first time you run the source, go to [http://localhost/install.php](http://localhost/install.php) to make a super user account and setup the directory structure. This needs to be done only once. 



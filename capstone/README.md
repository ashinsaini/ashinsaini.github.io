#Capstone FINAL PROJECT for CS50 2020

**Requirements**

	- This project sufficiently shows differences in the projects we were assigned during the course. 
	- This is not a social network project and is more rooted in data visualization and utilizing web
	  API calling to parse out retrieved data and manage to parse and than use *Chartjs* to visualize.
	  This is very distinct from any project that was handed out in the course.
	- There is *Django* used the main framework with at least one model utilized.  The back-end is utilizing
	  *Javascript* for the edge computing and rendering in the browser.
	- Mobile responsiveness has been achieved when hosting the site and was able to view and utilize all
	  the functions that were part of the project in mobile.

**Distinctivenss and Complexity**

	I believe this project satisfies complexity by having multiple pieces of data parsed and retrieved from
	a *Pandas* Dataframe and restructured inside a *Javascript* front-end *Chartjs* library.  This required self 		educating myself on the many different tools and objects manipulations that are part of *Chartjs*.  With 		learning about how to execute many of the configurations and setups, there were many setbacks in what would 
	work and what would require lots of trial and error.  This was fun and frustrating.
	Learning about ML libraries like *Pandas* being a very popular and powerful array tool was rewarding and added
	never before talked about feature, which has been added into this project.
	Having the app rendered mostly in one page also brings a good level of complexity as it requires the page to 		not refresh.

	Contents of files
		> Javascript: 
		```
		- stock.js : contains all the code for running the output front-end when after making initial call.
		- stock.css : the classes and *CSS* design calls for all the elements.
		```
		> HTML:
		```
		- index.html : this holds the code for the rendering of the first loaded page after logging in.
		- layout.html : this is the main styling and required file that maintains the frame of the app across 
				the other pages.
		- login.html : the login page is rendered here.
		- register.html : this is the page to register a login and account with the app.

		```

**Run This Application**

		
	
	To utilize and run this application you need to first register a username and password in order to get access
	to the app.  You can also add an image for your avatar.
	Once you have logged on you will be prompted to enter a stock ticker symbol.  You can find one from any 	exchange.  Mostly the tickers will only work with North American publicly listed companies.
	When entered you will be redirected to see a graph of the stocks performance over the past week by default.
	Here will be displayed the main price and a graph showing the close prices and high and low price points 
	indicated by the bars overlapping the line graph.  If you press on any of the buttons above that are time
	stamped they will show the performace of the stock over that time without reloading the page.
	At the top is a widget imported from *TradingView* which is an open sourced trading information and
	graph website.  It adds a nice socket of to show up to date info from the main indices.
	To log out just click the 'Log Out' link at the top when you are done.
	
	The API is from yahoo_fin, which has provided the API and returns the data as a *Pandas* Dataframe.

	Enjoy the beautiful visualization of data.  This was a fun experience and shows the possibilities of being
	able to make data more easy to parse and interpret visually at once rather than go through unstimulating 
	rows of numbers and dates.
	


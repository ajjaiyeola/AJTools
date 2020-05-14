<h1>Skill Building Tool</h1>


<h3>Problem</h3>

I noticed many new college students and recent graduates found it difficult to get guidance on specific skills and tools that would be helpful for career fields they are interested in.

<h3>Solution</h3>

Using data from the Bureau of Labor Statistics, I set out to build a tool that would ask a user about their college degree, occupational interests, and industry interests, and then present the user with the following information:

<ul>
<li>Occupations that most closely match their interests.</li>
<li>Salary and compensation information about the occupation.</li>
<li>Skills and technologies used in those occupations.</li>
</ul>

Ultimately, I aimed to build a platform that connected users with third-party vendors that will help them build on the skills they need to succeed. 

<h3>Implementation Specifics<h3>
  
<h4>app.php</h4>

<h4>responseprocessing.php</h4>

<h4>page.js</h4>

When you type in your choices, we search our database to see if there are matches. How does how database generate its data? The database has information contining BLS job codes, industry names, and degrees pre-stored When a user makes a search, we check our database to see if any of the key BLS elements exist If it exists, we send a request to BLS and parse the BLS result


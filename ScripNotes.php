<html>
<head>
<meta charset="ISO-8859-1">
<title>Notes</title>
<link rel="stylesheet" type="text/css" href="Resume.css">
<script src="vue.js"></script>

<script src="jquery-3.3.1.js"></script>
</head>
<body>

<div id="app">
<table>
	<tr>
		<th colspan=2 id="name">
			<h1>{{ contactname }}</h1>
		</th>
	</tr>
	<tr>
		<th colspan=2 id="contact">
			<h3>Cell: {{ contactphone }}<br/>
			Email: {{ contactemail }}</h3>
		</th>
	</tr>
	<tr>
		<td colspan=2 class="2ndarySection">
			<h2>Technical Skills</h2>
		</td>
	</tr>
	<tr>
		<td colspan=2 class="detailsSection">
			<span v-html="techSkill"></span>
		</td>
	</tr>
	<tr>
		<td colspan=2 class="2ndarySection">
			<h2>Certifications</h2>
		</td>
	</tr>
	<tr>
		<td colspan=2 class="detailsSection">
			<span v-html="certifications"></span>
		</td>
	</tr>
	<tr>
		<td colspan=2 class="2ndarySection">
			<h2>Education</h2>
		</td>
	</tr>
	<tr>
		<td colspan=2 class="detailsSection" id="education">
			<span v-html="education"></span>
		</td>
	</tr>
	<tr>
		<td colspan=2 class="PrimarySection">
			<h2>Job and Project Experience</h2>
		</td>
	</tr>
	<tr v-for="job in experience">
		<td class="company">
			<h3 class="companyName">{{ job[0].company }}</h3>
			<h4 class="companyTime">{{ job[1].startdate }} - {{ job[2].enddate }}</h4>
		</td>
		<td class="roles">
			<em>Roles -</em> <span v-html="job[3].roles"></span><br/>
			<em>Skills -</em> <span v-html="job[4].skills"></span><br/>
			<span v-html="job[5].detail"></span>
		</td>
	</tr>
	<tr>
		<td colspan=2 class="2ndarySection">
			<h2>Volunteering</h2>
			<p><span v-html="volunteer"></span></p>
		</td>
	</tr>
	<tr>
		<td colspan=2 class="2ndarySection">
			<h2>Soft Skills</h2>
			<p><span v-html="softSkill"></span></p>
		</td>
	</tr>
</table>
</div>

<script>
var resType = decodeURIComponent((new RegExp('[?|&]res=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null;
var request = new XMLHttpRequest();
request.open("GET", "ProjWork.xml", false);
request.send();
var xml = request.responseXML;
var contacts = xml.getElementsByTagName("contact");
var contactName = contacts[0].getElementsByTagName("contactname").item(0).textContent;
var contactPhone = contacts[0].getElementsByTagName("contactphone").item(0).textContent;
var contactEmail = contacts[0].getElementsByTagName("contactemail").item(0).textContent;
var techskill = xml.getElementsByTagName("techskills").item(0).textContent;
var certification = xml.getElementsByTagName("certifications").item(0).textContent;
var educations = xml.getElementsByTagName("education").item(0).textContent;
var volunteers = xml.getElementsByTagName("volunteer").item(0).textContent;
var softskill = xml.getElementsByTagName("softskills").item(0).textContent;
var jobs = xml.getElementsByTagName("job");

var jobsArr = [];
for(var i = 0; i < jobs.length; i++) {
	var companyName = jobs[i].getElementsByTagName("company").item(0).textContent;
	var startDate = jobs[i].getElementsByTagName("startmonth").item(0).textContent + " " + jobs[i].getElementsByTagName("startyear").item(0).textContent;
	var endDate = jobs[i].getElementsByTagName("endmonth").item(0).textContent + " " + jobs[i].getElementsByTagName("endyear").item(0).textContent;
	var role = jobs[i].getElementsByTagName("roles").item(0).textContent;
	var skill = jobs[i].getElementsByTagName("skills").item(0).textContent;
	var detailSub = jobs[i].getElementsByTagName("details");
	var detailAttr = detailSub[0].getAttributeNode("type").value;
	if (resType==null){
		resType = 'dev';
	}
	for(var j = 0; j < detailSub.length; j++) {
		var detailAttr = detailSub[j].getAttributeNode("type").value;
		if (detailAttr==resType){
			var details = detailSub[j].textContent;
		}
	}
	
	var jobArr = [
		{company : companyName},
	    {startdate : startDate},
	    {enddate : endDate},
	    {roles : role},
	    {skills : skill},
      	{detail : details}
    ];
    jobsArr.push(jobArr);
	//alert(jobsArr.length + ' checking '+ jobsArr.length);
	//alert(contactName+contactPhone+contactEmail+techskill+certification+educations+volunteers+softskill);
}

var app = new Vue({
   	el: '#app',
   	data: {
       	message: 'Hello Vue World',
       	experience: jobsArr,
       	contactname: contactName,
       	contactphone: contactPhone,
       	contactemail: contactEmail,
       	techSkill: techskill,
       	certifications: certification,
       	education: educations,
      	volunteer: volunteers,
       	softSkill: softskill,
	}
})

</script>
</body>
</html>
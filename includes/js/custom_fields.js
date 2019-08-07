// document.addEventListener('DOMContentLoaded', () => {
//   console.log('custom js for this plugin is now loaded, do something!');
// }, false);


const jobStatusOptions = document.getElementsByName('projectJobStatus');
// const labels = inputs.querySelectorAll('label');
// Take the radio buttons in the projectJobStatus field and  give them a bolder font-weight.
jobStatusOptions.forEach( option => {
  const jobStatusOption = option.nextElementSibling;
  jobStatusOption.style.fontWeight = 'bolder';
});

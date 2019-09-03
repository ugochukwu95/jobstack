$(".save_job'.$i.'").on("click". function() {
							$.get("'.$jobs_list->mJobs[$i]['link_to_add_job'].'", 
							"", 
							function(data) {
								var textBadge = $(".badge").text();
								textBadge++;
								$(".badge").text(textBadge); // Alter number of saved jobs
								$(".if_saved_job_card'.$i.'").removeClass("teal").addClass("red"); // toggle card color
								$(".if_add_star'.$i.'").html("<i class=\"far fa-star\"></i>");
								$(".save_job'.$i.'").replaceWith("<button class=\"btn-flat teal-text unsave_job'.$i.'\">Unsave</button>");
							})
						});
						$(".unsave_job'.$i.'").on("click", function() {
							$.get("'.((isset($jobs_list->mJobs[$i]['link_to_remove_job'])) ? echo $jobs_list->mJobs[$i]['link_to_remove_job'] : "").',
							"", 
							function(data) {
								var textBadge = $(".badge").text();
								textBadge--;
								$(".badge").text(textBadge); // Alter number of saved jobs
								$(".if_saved_job_card'.$i.'").removeClass("red").addClass("teal"); // toggle card color
								$(".if_add_star'.$i.'").html(" ");
								$(".unsave_job'.$i.'").replaceWith("<button class=\"btn-flat teal-text save_job'.$i.'\">Save</button>");
							})
						});
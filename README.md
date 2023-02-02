# Pace Creative Knowledge Test Responses - Chrisitne Shiels

1. If there is a difference between live, staging, and git and I need to add a functionality, I would add a branch to the git and fetch the code from the live site to add my new code to.

    This would ensure that I was working off the latest code from the live site, so as not to inadvertently add any unfinished or untested code from staging or other git branches, and also document the changes I made in a separate branch.
---
2. (see single.php file in repository)

    For this question, I added the WordPress Hook to the single.php template file from the Twenty-Twenty***** WordPress theme.
---
3. This query will display results of published posts from a Custom Post Type (CPT) called 'disney.' They will display 5 per page in alphabetical order of Post Title.

    It further filters these posts by two custom taxonomies, returning only the 'disney' CPT posts that are tagged with term slugs of 'el-gato-con-botas' or 'blanca-nieves' in the 'movies' custom taxonomy AND are also tagged in the 'series' custom taxomy with terms that have IDs of 20, 21, 22, or 23.

    The meta query also further filters the results by post meta, possibly ACF fields, to only those 'year' fields with a value of 2000, OR an 'available' value of 0.

    To sum up, it will generate a list of published 'disney' posts with the following parameters:
    - 'movies' => 'el-gato-con-botas' OR 'blanca-nieves'
    
    that also have (AND)    

    - 'series' => taxonomy IDs 20, 21, 22 OR 23

    with (AND)

       - 'year' => 2000 OR 'available' => 0
 

"use strict";

/***************************
* scripts.js
* globals, for use in common and unique script documents
* from http://stackoverflow.com/a/7048295
***************************/

/**
 * After all things load...
 **/
document.addEventListener('DOMContentLoaded', function() {

    /*********************
    * Thumbnail Project Popup
    * from https://material.io/components/web/catalog/dialogs/
    *********************/
        var revealList = document.getElementById('reveal-list');
        var revealItems = document.querySelectorAll('.reveal-item');
        var infoBox = document.getElementById('member-info-box');

        // when click on team member
        $('.reveal-item').on('click', function (evt) {
            // clear other colors
            for (var i = 0; i < revealItems.length; i++) {
                revealItems[i].classList.remove('is-highlighted');
            };

            evt.preventDefault();
            var $this = $(this);

            // add coloring (b/c otherwise adds 30k to stylesheet)
            $this.addClass('is-highlighted');

            // get project info for populating info box
            var listItemData = $this.data('list-item-data');

            // hide other team section details so don't show wrong text when gets replaced
            revealList.setAttribute('data-member-order', '');

            // give index to list for info box positioning via CSS
            revealList.setAttribute('data-member-order', $this.css('order'));

            // vars for storing two images
            var memberGlideBullets = document.getElementById('member-glide-bullets');


            // Parse the string back into a proper JSON object, from https://stackoverflow.com/q/7322682
            // hide all and show all relevent data
            $.each(listItemData, function(index, element) {
                // find target element, from https://stackoverflow.com/a/12166811/4504073
                var targetClassName = '.member-info-' + index;

                var targetElement = infoBox.querySelectorAll(targetClassName);

                if(index == 'images') {
                    // clear out old picture element
                    while (targetElement[0].firstChild) {
                        targetElement[0].removeChild(targetElement[0].firstChild);
                    }

                    // clear out old bullets
                    while (memberGlideBullets.firstChild) {
                        memberGlideBullets.removeChild(memberGlideBullets.firstChild);
                    }

                    // for each image...
                    for (var i = 0; i < element.length; i++) {
                        // make new picture element, from https://stackoverflow.com/a/50596050/4504073
                        var slide = document.createElement('li');
                        var picture = document.createElement('picture');
                        var src = document.createElement('source');
                        var img = document.createElement('img');

                        // Slide
                        slide.className = 'glide__slide';

                        // Picture
                        picture.className = 'member-picture';

                        // Source
                        src.srcset = element[i]['1x'] + ', ' + element[i]['2x'] + ' 2x';
                        src.media = "(min-width: 769px)";

                        // Image
                        img.srcset = element[i]['1x'];
                        img.alt = 'BID Member';

                        // combine
                        picture.appendChild(src);
                        picture.appendChild(img);
                        slide.appendChild(picture);

                        console.log('targetElement[0]', targetElement[0]);

                        // add to doc
                        targetElement[0].appendChild(slide);

                        // and add a bullet if have more than one image
                        if(element.length > 1) {
                            var bullet = document.createElement('button');
                            bullet.className = 'glide__bullet';
                            bullet.setAttribute('data-glide-dir', '=' + i);
                            memberGlideBullets.appendChild(bullet);
                        }                            
                    }

                    // instantiate GlideJS for slideshow
                    var glide = new Glide('#glide', {
                        gap: 0,
                    });
                    glide.mount();

                } else if(typeof targetElement[0] !== 'undefined') {
                    console.log('targetElement[0]', targetElement[0]);
                    targetElement[0].innerHTML = element;
                }
                
            });

        })

        // hide team member info box
        $('.member-close-button').on('click', function() {
            console.log('member close');
            // hide box by remove CSS that shows it!
            revealList.setAttribute('data-member-order', 0);
            $(this).removeClass('is-highlighted');
        });

        // // show missing team members if url parameter set
        // var showMissingMembers = getParameterByName('show-missing');

        // // Set the cookies if anything is in url parameters
        // if(showMissingMembers) {
        //     site.$body.addClass('show-missing-list-items'); 
        // }

});

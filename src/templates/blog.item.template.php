<?php
/**Function that fills the variables of the heredocs
 * @return the heredoc filled
 */
    function getBlogItem($id, $collapse,$expanded,$date,$title,$expanded_div,$content){
        $news_content = <<<END_OF_NEW
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-heading{$id}">
                                <button class="accordion-button {$collapse}" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse{$id}" aria-expanded="{$expanded}" aria-controls="panelsStayOpen-collapse{$id}">
                                    {$date}
                                </button>
                            </h2>

                            <div id="panelsStayOpen-collapse{$id}" class="accordion-collapse collapse {$expanded_div}" aria-labelledby="panelsStayOpen-heading{$id}">
                                <div class="accordion-body">
                                    <strong>{$title}</strong><br>
                                    {$content}
                                </div>
                            </div>
                        </div>           
                        END_OF_NEW;
        return $news_content; 
    }
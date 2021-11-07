{config_load file="test.conf" section="setup"}
{include file="header.tpl" title=Calendar}

<PRE>

{* bold and title are read from the config file *}
    {if #bold#}<b>{/if}
        {* capitalize the first letters of each word of the title *}
        Title: {#title#|capitalize}
        {if #bold#}</b>{/if}

    The current date and time is {$smarty.now|date_format:"%Y-%m-%d %H:%M:%S"}    

    Example of accessing server environment variable SERVER_NAME: {$smarty.server.SERVER_NAME}

    The value of {ldelim}$Name{rdelim} is <b>{$Name}</b>

variable modifier example of {ldelim}$Name|upper{rdelim}

<b>{$Name|upper}</b>


</PRE>

This is an example of the html_select_date function:

<p>SELECTED: {$selected_year}</p>
<form action='{$SCRIPT_NAME}' method='post' id="selectYear">
    {html_select_date start_year='-5' end_year='+5' field_order=YMD display_days=false display_months=false}
</form>

<article class="agenda">
    {foreach $agenda as $month}
        <section class="month">
            {html_radios name='month' output=$month@key values=$month@iteration labels=false selected=$selected_month}
            <ul class="monthList">
                {foreach $month as $day}
                    <li class='day' data-month='{$month@iteration}' data-day='{$day@key}'>
                        {foreach $day as $notes}
                            <details>
                                <summary {if !empty($notes)} class="modified" {/if}>{$day@key|regex_replace:"/[-+]/":" "}</summary>
                                <ul>
                                    <li class="dayName">
                                        <h2>{$notes@key}</h2>
                                    </li>
                                    {foreach $notes as $note}
                                        <li>
                                            <p class="note">{$note}</p>
                                            <time>{$note@key|date_format:'%e %b, %Y, %H:%M:%S'}</time>
                                            <a
                                                href='{$SCRIPT_NAME}?action=delete&d={urlencode($day@key)}&m={$month@iteration}&stamp={$note@key}'>delete</a>
                                        </li>
                                    {/foreach}
                                {/foreach}
                                <form action="{$SCRIPT_NAME}?action=add&d={urlencode($day@key)}&m={$month@iteration}"
                                    method='post'>
                                    <input type="submit" value="Add">
                                    <input type='text' name='note'>
                                </form>
                            </ul>
                        </details>
                    </li>
                {/foreach}
            </ul>
        </section>
    {/foreach}
</article>

{include file="footer.tpl"}
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

An example of a section loop:

    {section name=outer
    loop=$FirstName}
        {if $smarty.section.outer.index is odd by 2}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                {$smarty.section.outer.rownum} . {$FirstName[outer]} {$LastName[outer]}
        {else}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                {$smarty.section.outer.rownum} * {$FirstName[outer]} {$LastName[outer]}
        {/if}
        {sectionelse}
        none
    {/section}

    An example of section looped key values:

    {section name=sec1 loop=$contacts}
                phone: {$contacts[sec1].phone}
                <br>
                    fax: {$contacts[sec1].fax}
                <br>
                    cell: {$contacts[sec1].cell}
                <br>
    {/section}
    <p>

        testing strip tags
        {strip}
             <table border=0>
            <tr>
                <td>
                    <A HREF="{$SCRIPT_NAME}">
                        <font color="red">This is a test </font>
                    </A>
                </td>
            </tr>
             </table>
    {/strip}

</PRE>

This is an example of the html_select_date function:

<p>SELECTED: {$selected_year}</p>
<form action='{$SCRIPT_NAME}' method='post' id="selectYear">
    {html_select_date start_year='-5' end_year='+5' field_order=YMD display_days=false display_months=false}
</form>

This is an example of the html_select_time function:
<form action='/' method='post'>
    {html_select_time field_separator=':'}
</form>

This is an example of the html_options function:

<form>
    <select name=states>
        {html_options values=$option_values selected=$option_selected output=$option_output}
    </select>
</form>
<article class="agenda">
    {foreach $agenda as $month}
        <section class="month">
            <h2><label for="month-{$month@iteration}" style='font-weight:bold;'> {$month@key} </label></h2>
            <input type="radio" id="month-{$month@iteration}" name="month">
            <ul class="monthList">
                {foreach $month as $day}
                    <li class='day' data-month='{$month@iteration}' data-day='{$day@iteration}'>
                        {foreach $day as $notes}
                            {$day@key} +++++ {$notes@key}
                            <ul>
                                {foreach $notes as $note}
                                    <li>{$note@key} => {$note}</li>
                                {/foreach}
                            {/foreach}
                        </ul>
                    </li>
                {/foreach}
            </ul>
        </section>
    {/foreach}
</article>

{include file="footer.tpl"}
{include file="header"}
{include file="menu"}


<form class="column" action="?page=userEdit&amp;userID={#$userID}" method="post">
    <div class="content-box">
        <ul class="panel tabs" data-tab role="tablist">
            <li role="presentational"
                class="tab-title small active"><a
                        href="index.php?page=userEdit&userID={#$userID}#categoryGeneral">{lang "user.profil.category.general"}</a>
            </li>
        </ul>
        <div class="tabs-content">
            <div class="column content panel container active" aria-hidden="true" id="categoryGeneral">
                <fieldset>
                    <legend>{lang "user.user"}</legend>
                    <div class="row">
                        <div class="large-12 small-12 medium-12 columns">
                            <label>{lang "user.username"}
                                <input type="text"{error var="username"} class="error"{/error} name="username" id="username" value="{$username}">
                            </label>
                            {error var="username"}
                                <small class="error">
                                    {if $errorType == "empty"}
                                        {lang "system.form.empty"}
                                    {else}{lang "user.profil.error.username.".$errorType}
                                    {/if}
                                </small>
                            {/error}
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>{lang "user.password.change"}</legend>
                    <div class="row">
                        <div class="large-12 small-12 medium-12 columns">
                            <label>{lang "user.password"}
                                <input type="text"{error var="password"} class="error"{/error} name="password" id="password" value="{$password}">
                            </label>
                            {error var="password"}
                                <small class="error">
                                    {if $errorType == "empty"}
                                        {lang "system.form.empty"}
                                    {else}{lang "user.profil.error.password.".$errorType}
                                    {/if}
                                </small>
                            {/error}
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 small-12 medium-12 columns">
                            <label>{lang "user.password.again"}
                                <input type="text"{error var="passwordAgain"} class="error"{/error} name="passwordAgain" id="passwordAgain" value="{$passwordAgain}">
                            </label>
                            {error var="passwordAgain"}
                                <small class="error">
                                    {if $errorType == "empty"}
                                        {lang "system.form.empty"}
                                    {else}{lang "user.profil.error.password.".$errorType}
                                    {/if}
                                </small>
                            {/error}
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>{lang "user.mail.change"}</legend>
                    <div class="row">
                        <div class="large-12 small-12 medium-12 columns">
                            <label>{lang "user.mail"}
                                <input type="text"{error var="mail"} class="error"{/error} name="mail" id="mail" value="{$mail}">
                            </label>
                            {error var="mail"}
                                <small class="error">
                                    {if $errorType == "empty"}
                                        {lang "system.form.empty"}
                                    {else}{lang "user.profil.error.mail.".$errorType}
                                    {/if}
                                </small>
                            {/error}
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 small-12 medium-12 columns">
                            <label>{lang "user.mail.again"}
                                <input type="text"{error var="mailAgain"} class="error"{/error} name="mailAgain" id="mailAgain" value="{$mailAgain}">
                            </label>
                            {error var="mailAgain"}
                                <small class="error">
                                    {if $errorType == "empty"}
                                        {lang "system.form.empty"}
                                    {else}{lang "user.profil.error.mail.".$errorType}
                                    {/if}
                                </small>
                            {/error}
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <div class="row large-12 small-12 medium-12 fullRow">
        <div class="large-5 small-12 medium-3 columns">
        </div>
        <div class="large-7 small-12 medium-9 columns">
            <button type="submit"> {lang "system.global.button.send"}</button>
            <button type="submit"> {lang "system.global.button.back"}</button>
        </div>
    </div>
</form>
{include file="footer"}
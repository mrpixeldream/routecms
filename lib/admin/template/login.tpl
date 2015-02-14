{include file="header"}
<div class="row" style="max-width: 500px;">
    <div class="topBox small-12 medium-12 large-12 medium-centered large-centered columns">
        <form action="?page=Login" method="post">
            <div class="loginBox">
                <fieldset>
                    <div class="row">
                        <div class="small-12 medium-12 large-12 columns">
                            <div class="row">
                                <div class="small-4 medium-4 large-5 columns"></div>
                                <div class="small-8 medium-8 large-8 columns" id="logo">
                                    <a href="index.php?page=Login"><img src="images/logo.png" alt="logo"></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="small-12 medium-12 large-12 first-column columns">
                                    {lang "system.page.login.title"}
                                </div>
                            </div>
                            <div class="row">
                                <div class="small-12 medium-12 large-12 second-column columns">
                                    <div class="icon-in-input">
                                        <span class="fi-torso"> | </span>
                                        <input type="text"{error var="username"} class="error"{/error}
                                               value="{$username}"
                                               name="username" placeholder="{lang "system.username"}">
                                        {error var="username"}
                                            <small class="error">
                                                {if $errorType == "empty"}
                                                    {lang "system.form.empty"}
                                                {else}{lang "user.login.error.".$errorType}
                                                {/if}
                                            </small>
                                        {/error}
                                    </div>
                                    <div class="icon-in-input">
                                        <span class="fi-unlock"> | </span>
                                        <input type="password"{error var="password"} class="error"{/error} value=""
                                               name="password" placeholder="{lang "system.password"}">
                                        {error var="password"}
                                            <small class="error">
                                                {if $errorType == "empty"}
                                                    {lang "system.form.empty"}
                                                {else}{lang "user.login.password.error.".$errorType}
                                                {/if}
                                            </small>
                                        {/error}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="small-12 medium-12 large-12 last-column columns">
                                    <button type="submit"
                                            class="fi-arrow-right"> {lang "system.page.login.submit"}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </form>
    </div>
</div>
{include file="footer"}
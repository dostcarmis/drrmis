{{-- IMPLEMENTATION --}}
<div class="row">
    <div class="col-sm-6">
        <h2>Access Restriction</h2>
        <h3>hasAccess() method</h3>
        <p>The <i>User</i> model has a <code>hasAccess()</code> method that checks the <code>role_modules</code> table for the user's access to each module.</p>
        <h4 class="mt-5">Parameters</h4>
        <p><code>&lt;moduleID&gt;</code> is required while <code>&lt;crud&gt;</code> is optional.</p>
        <table class="table table-striped">
            <thead>
                <tr><th>Parameter</th><th>Accepted values</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>moduleID</td>
                    <td><i>int</i> | <strong>required</strong> | ID is from the modules table in the database</td>
                </tr>
                <tr><td>crud</td><td><i>string</i> | <strong>optional</strong> | 'create' | 'read' | 'update' | 'delete'</td></tr>
            </tbody>
        </table>
        <h4 class="mt-5">Return values</h4>
            <p>The method returns a <code><i>bool</i></code> value.</p>
            <p><code>Auth::user()->hasAccess('&lt;moduleID&gt;')</code> returns true if the user has an access to any CRUD action of the specified module.</p>
            <p><code>Auth::user()->hasAccess('&lt;moduleID&gt;','&lt;crud&gt;')</code> returns true if the user has an access to a specific CRUD action of the specified module.</p>
        <h4 class="mt-5">Limiting access</h4>
        <p>Once users have been given access to a particular module, you can implement access control by surrounding the resource links with the following code</p>
        <pre>
&#64;if(Auth::user()->hasAccess('&lt;moduleID&gt;','&lt;crud&gt;'))
    //resource
&#64;endif
        </pre>
        <h4 class="mt-5">Example</h4>
        <p>If you want to make an access available to users with access to the <strong>Users management</strong> module (ID = 6) and has the ability to <strong>read</strong> the data, then you can implement the following code:</p>
        <pre>
//Access controller<br>
&#64;if(Auth::user()->role_id <= 1 || <b>Auth::user()->hasAccess(6,'read')</b>)
    //Restricted resource
    &lt;a href="&#123;&#123; action("UserlogsController@viewactivitylogs") &#125;&#125;">
        &lt;i class="fa fa-user-secret">&lt;/i> User Activity
    &lt;/a>
&#64;endif
        </pre>
        
        <hr>
        <h2>Dynamic Nav</h2>
        <h3>module() method</h3>
        <p>The <i>User</i> model has a <code>module()</code> method that returns a <i>Collection</i> instance of modules the user has access to.</p>
        <h4 class="mt-5">Parameters</h4>
        <p><code>&lt;moduleID&gt;</code> is optional.</p>
        <table class="table table-striped">
            <thead>
                <tr><th>Parameter</th><th>Accepted values</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>moduleID</td>
                    <td><i>int</i> | <strong>optional</strong> | ID is from the modules table in the database</td>
                </tr>
            </tbody>
        </table>
        <h4 class="mt-5">Return values</h4>
        <p>The method may return different results depending on whether a module ID is provided or not.</p>
        <p><code>Auth::user()->module()</code> returns a Collection of modules accessible by the User</p>
        <p><code>Auth::user()->module('&lt;moduleID&gt;')</code> returns a <i>Module</i> class instance if the user has access to the module. Otherwise, it returns <code>false</code>.</p>
        <h4 class="mt-5">Usage</h4>
        <strong>Auth::user()->module()</strong><br>
        <p>To access the Collection instance, you should iterate over it using for-each loops</p>
        <pre>
//In blade templates
&#64;foreach( Auth::user()->module() as $module)
    &lt;div>&#123;&#123;$module->id&#125;&#125;&lt;/div>
&#64;endforeach
        </pre>
        <pre class="mt-3">
//In backend
foreach( Auth::user()->module() as $module){
    //do something
}
        </pre><br>
        <strong>Auth::user()->module(&lt;moduleID&gt;)</strong><br>
        <p>You can access the <i>Module</i> class instance's attributes directly like a regular std Object</p>
        <pre>
//Modules have name, description, and remarks attributes
Auth::user()->module(1)->name            
        </pre>
        <h4 class="mt-5">Navigation Setup</h4>
        <p>In <strong>views/layouts/partials/navsidebar.blade.php</strong>, you can set up dynamic links with access controls by following the pattern below:</p>
        <pre>
&#64;if (Auth::user()->hasAccess(2))
&lt;li>
    &lt;a href="#">
        &lt;span class="nav-module">&#123;&#123;Auth::user()->module(2)->name&#125;&#125;&lt;/span>
    &lt;/a>
&lt;/li>
&#64;endif
        </pre>
        <p><strong>IMPORTANT:</strong></p>
        <p>Make sure that the &lt;moduleID> passed to <code>hasAccess()</code> and <code>module()</code> are the same. </p>
        <p>You should also surround the module name with <code>&lt;span class="nav-module"></code> to enable dynamic nav changes.</p>
    </div>
    <div class="col-sm-6"></div>
</div>
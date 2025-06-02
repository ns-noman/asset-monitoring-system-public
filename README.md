  <h1>🏢 Branch Asset Monitoring System</h1>
  <p>
    A web-based asset monitoring and tracking system developed using <strong>Laravel</strong> and modern frontend technologies. 
    This system manages assets across multiple branches, tracks assignment, location, status (e.g. working, faulty, dead), and supports inter-branch transfer and requisition.
  </p>

  <hr />

  <h2>🌐 Key Modules</h2>

  <ul>
    <li><strong>Asset Management:</strong> Create, categorize, and monitor assets like computers, ACs, chairs, fans, lights, etc.</li>
    <li><strong>Status Tracking:</strong> Mark assets as working, damaged, dead, etc. Track temporary and historical statuses.</li>
    <li><strong>Branch Transfers:</strong> Transfer assets between branches with full traceability and requisition approval.</li>
    <li><strong>Employee Management:</strong> Manage employee info, departments, designations, and asset assignments.</li>
    <li><strong>Role-based Access:</strong> Control privileges using roles, menus, and user permissions.</li>
  </ul>

  <hr />

  <h2>🛠️ Technologies Used</h2>
  <ul>
    <li><strong>Backend:</strong> Laravel (PHP Framework)</li>
    <li><strong>Frontend:</strong> HTML, CSS, Bootstrap</li>
    <li><strong>Scripting:</strong> JavaScript, jQuery, AJAX</li>
    <li><strong>Database:</strong> MySQL</li>
  </ul>

  <hr />

  <h2>🚀 Getting Started</h2>

  <h3>📥 1. Clone the Repository</h3>
  <pre><code>git clone https://github.com/ns-noman/asset-monitoring-system-public.git
cd branch-asset-monitoring-system</code></pre>

  <h3>📦 2. Install Dependencies</h3>
  <pre><code>composer install
npm install &amp;&amp; npm run dev</code></pre>

  <h3>⚙️ 3. Configure Environment</h3>
  <pre><code>cp .env.example .env
php artisan key:generate</code></pre>
  <p>Update your <code>.env</code> file with database credentials:</p>
  <pre><code>DB_DATABASE=your_database
  DB_USERNAME=your_username
  DB_PASSWORD=your_password</code></pre>

  <h3>🧱 4. Migrate Database</h3>
  <pre><code>php artisan migrate</code></pre>

  <h3>▶️ 5. Run the Application</h3>
  <pre><code>php artisan serve</code></pre>

  <hr />

  <h2>👤 Author</h2>
  <p>
    <strong>Nowab Shorif Noman</strong><br />
    Web Application Developer<br />
    📧 <a href="mailto:nsanoman@gmail.com">nsanoman@gmail.com</a><br />
    🔗 <a href="https://www.linkedin.com/in/nowab-shorif/" target="_blank">LinkedIn</a> |
    💻 <a href="https://github.com/ns-noman" target="_blank">GitHub</a>
  </p>

  <hr />

  <h2>📄 License</h2>
  <p>
    This project is licensed.
  </p>

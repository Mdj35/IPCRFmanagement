<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DSWD - User Profile</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e8f4f8 0%, #f0e6f6 50%, #ffe6e6 100%);
            min-height: 100vh;
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 70px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 0;
            gap: 25px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
        }

        .nav-item {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #999;
        }

        .nav-item:hover {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .nav-item.active {
            background: #667eea;
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .nav-item svg {
            width: 22px;
            height: 22px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
        }

        .header {
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 28px;
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .header .date {
            font-size: 14px;
            color: #718096;
        }

        /* Profile Card */
        .profile-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .card-header {
            height: 120px;
            background: linear-gradient(90deg, #a8edea 0%, #fed6e3 50%, #f5f7fa 100%);
            position: relative;
        }

        .profile-body {
            padding: 0 40px 40px;
            position: relative;
        }

        .profile-header {
            display: flex;
            align-items: flex-end;
            margin-top: -50px;
            margin-bottom: 30px;
        }

        .avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid white;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            background: #f0f0f0;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-info {
            margin-left: 20px;
            margin-bottom: 10px;
        }

        .profile-info h2 {
            font-size: 22px;
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .profile-info .email {
            font-size: 14px;
            color: #718096;
        }

        /* Form Grid */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            font-size: 12px;
            color: #4a5568;
            font-weight: 500;
            margin-bottom: 8px;
            text-transform: capitalize;
        }

        .form-group input,
        .form-group select {
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            color: #2d3748;
            background: #f7fafc;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group input::placeholder {
            color: #a0aec0;
        }

        /* Email Section */
        .email-section {
            margin-top: 20px;
            padding-top: 30px;
            border-top: 1px solid #e2e8f0;
        }

        .email-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: #f7fafc;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .email-text {
            font-size: 14px;
            color: #2d3748;
        }

        .email-remove {
            font-size: 12px;
            color: #e53e3e;
            cursor: pointer;
            font-weight: 500;
            transition: color 0.3s;
        }

        .email-remove:hover {
            color: #c53030;
            text-decoration: underline;
        }

        .btn-add-email {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #ebf8ff;
            color: #3182ce;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-add-email:hover {
            background: #bee3f8;
            transform: translateY(-1px);
        }

        .btn-add-email svg {
            width: 16px;
            height: 16px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
            }
            
            .main-content {
                padding: 20px;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .profile-header {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            
            .profile-info {
                margin-left: 0;
                margin-top: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="nav-item active" title="Profile">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
        </div>
        <div class="nav-item" title="Dashboard">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
            </svg>
        </div>
        <div class="nav-item" title="Users">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
        </div>
        <div class="nav-item" title="Messages">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
            </svg>
        </div>
        <div class="nav-item" title="Settings">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
        </div>
        <div style="margin-top: auto;">
            <a href="{{ route('logout') }}" class="nav-item" title="Logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="header">
            <h1>Welcome, {{ Auth::user()->name ?? 'John Doe' }}</h1>
            <p class="date">{{ now()->format('D, d F Y') }}</p>
        </div>

        <div class="profile-card">
            <div class="card-header"></div>
            
            <div class="profile-body">
                <div class="profile-header">
                    <div class="avatar">
                        <img src="{{ Auth::user()->avatar ?? 'https://i.pravatar.cc/150?img=5' }}" alt="Profile Picture">
                    </div>
                    <div class="profile-info">
                        <h2>{{ Auth::user()->name ?? 'John Doe' }}</h2>
                        <p class="email">{{ Auth::user()->email ?? 'alexarawles@gmail.com' }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" id="full_name" name="full_name" value="{{ Auth::user()->name ?? 'John Doe' }}" placeholder="Enter full name">
                        </div>

                        <div class="form-group">
                            <label for="birthday">Birthday</label>
                            <input type="text" id="birthday" name="birthday" value="{{ Auth::user()->birthday ?? 'January 1, 2002' }}" placeholder="Select birthday">
                        </div>

                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <input type="text" id="gender" name="gender" value="{{ Auth::user()->gender ?? 'Female' }}" placeholder="Select gender">
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" id="address" name="address" value="{{ Auth::user()->address ?? 'Sample City' }}" placeholder="Enter address">
                        </div>

                        <div class="form-group full-width">
                            <label for="region">Region</label>
                            <input type="text" id="region" name="region" value="{{ Auth::user()->region ?? 'sample' }}" placeholder="Enter region">
                        </div>
                    </div>

                    <div class="email-section">
                        <div class="email-item">
                            <span class="email-text">{{ Auth::user()->email ?? 'alexarawles@gmail.com' }}</span>
                            <span class="email-remove">remove</span>
                        </div>

                        <button type="button" class="btn-add-email">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Email Address
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ISA // Tactical Operations Center</title>
    <!-- Google Fonts: Cormorant Garamond & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600;700&family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        isa: {
                            gold: '#c5a880',      // Muted Champagne Gold
                            goldMuted: 'rgba(197, 168, 128, 0.15)',
                            emerald: '#1e4620',   // Understated Forest Green
                            emeraldText: '#a3b899',
                            dark: '#080a0f',      // Matte Deep Charcoal
                            navy: '#0f131c',      // Midnight Navy Surface
                            slate: '#171e2b',     // Card Surface
                            burgundy: '#4c1d1d'   // Redaction / Critical alert
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'Tajawal', 'sans-serif'],
                        serif: ['Cormorant Garamond', 'serif']
                    }
                }
            }
        }
    </script>
    <style>
        /* شريط التمرير الراقي */
        ::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }
        ::-webkit-scrollbar-track {
            background: #080a0f;
        }
        ::-webkit-scrollbar-thumb {
            background: #c5a880;
            border-radius: 2px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #a3b899;
        }

        /* ملمس معدني ناعم جداً للخلفية */
        .brushed-bg {
            background: radial-gradient(circle at 50% 50%, #111521 0%, #06080c 100%);
            position: relative;
        }

        /* توهج ذهبي مطفي هادئ عند التفاعل */
        .executive-glow {
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .executive-glow:hover {
            box-shadow: 0 10px 30px rgba(197, 168, 128, 0.03);
            border-color: rgba(197, 168, 128, 0.3);
            background: rgba(23, 30, 43, 0.65);
            transform: translateY(-1px);
        }

        /* أنيميشن الاهتزاز الفيزيائي الهادئ عند الخطأ */
        @keyframes subtle-shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-4px); }
            40%, 80% { transform: translateX(4px); }
        }
        .shake-trigger {
            animation: subtle-shake 0.4s ease-in-out;
        }

        /* تأثير التعتيم والرقابة الاستخباراتية */
        .redacted-block {
            background-color: #080a0f;
            color: #080a0f;
            user-select: none;
            display: inline-block;
            padding: 0 4px;
            border-radius: 2px;
        }
    </style>
</head>
<body class="bg-isa-dark text-slate-300 font-sans min-h-screen relative overflow-x-hidden brushed-bg">

    <!-- إضاءة خلفية ناعمة جداً لمحاكاة الإضاءة المحيطة الخافتة -->
    <div class="absolute top-1/4 left-1/4 w-[500px] h-[500px] bg-isa-gold/5 rounded-full blur-[120px] pointer-events-none z-0"></div>
    <div class="absolute bottom-1/4 right-1/4 w-[500px] h-[500px] bg-slate-800/20 rounded-full blur-[120px] pointer-events-none z-0"></div>

    <!-- ======================================================== -->
    <!-- 1. واجهة تسجيل الدخول الرسمية والسيادية -->
    <!-- ======================================================== -->
    <div id="auth-screen" class="relative z-10 flex flex-col items-center justify-center min-h-screen p-4">
        
        <!-- صندوق الدخول الاستخباراتي -->
        <div id="auth-card" class="w-full max-w-xl bg-isa-navy/95 border border-slate-800 rounded-lg p-8 md:p-10 shadow-2xl relative transition-all duration-300">
            <!-- زوايا تكتيكية ذهبية بالغة الدقة -->
            <div class="absolute top-0 right-0 w-3 h-3 border-t border-r border-isa-gold/40"></div>
            <div class="absolute bottom-0 left-0 w-3 h-3 border-b border-l border-isa-gold/40"></div>

            <div class="flex flex-col items-center text-center">
                <!-- شعار المخابرات الفيكتوري الراقي (SVG) -->
                <div class="w-16 h-16 text-isa-gold mb-6">
                    <svg viewBox="0 0 100 100" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-full h-full">
                        <circle cx="50" cy="50" r="45" stroke="currentColor" stroke-dasharray="1 3"/>
                        <circle cx="50" cy="50" r="38" stroke="currentColor" />
                        <path d="M50 20 L50 80 M20 50 L80 50" stroke-width="0.75" stroke-dasharray="2 2" />
                        <polygon points="50,28 62,50 50,72 38,50" />
                        <circle cx="50" cy="50" r="5" fill="currentColor"/>
                    </svg>
                </div>

                <h1 class="serif-title text-2xl font-bold text-white tracking-widest uppercase mb-1">INTELLIGENCE SECURITY AGENCY</h1>
                <span class="text-[10px] font-mono text-isa-gold tracking-widest uppercase">Central Authentication Portal // Class 4 Clearance</span>
                
                <div class="w-full my-6 border-b border-slate-800/80"></div>

                <!-- التحذير الفيدرالي المصاغ بأسلوب رسمي وقور -->
                <p class="text-[11px] text-slate-400 leading-relaxed mb-6 text-right bg-isa-dark/50 p-4 border-r-2 border-isa-gold/30">
                    <strong>تنبيه رسمي:</strong> هذا النظام مخصص حصرياً للمحققين الحاصلين على تصريح أمني نشط من وكالة الأمن والاستخبارات (ISA). يمنع محاولة الولوج غير المصرح بها منعاً باتاً تحت طائلة القوانين الفيدرالية للأمن الوطني وحماية البيانات السيادية.
                </p>

                <!-- نموذج الدخول الاستخباراتي -->
                <form id="auth-form" method="POST" action="/login" class="w-full space-y-5 text-right">
    @csrf                    
                    <!-- رسالة الرفض الأمني -->
                    <div id="auth-error" class="hidden flex items-start gap-3 bg-isa-burgundy/10 border border-isa-burgundy text-red-400 p-3.5 rounded text-xs leading-relaxed">
                        <i class="fa-solid fa-circle-exclamation text-sm mt-0.5"></i>
                        <div>
                            <span class="font-bold">ACCESS DENIED / تم رفض الطلب:</span>
                            <p class="text-[10px] text-slate-300 mt-1">كود التعريف المدخل غير مسجل في قواعد بيانات المصادقة. تم تقييد إحداثيات الاتصال الحالية.</p>
                        </div>
                    </div>

                    <!-- رسالة القبول الموثوقة -->
                    <div id="auth-success" class="hidden flex items-start gap-3 bg-isa-emerald/10 border border-isa-emerald text-emerald-400 p-3.5 rounded text-xs leading-relaxed">
                        <i class="fa-solid fa-circle-check text-sm mt-0.5"></i>
                        <div>
                            <span class="font-bold">CLEARANCE APPROVED / تم التصريح:</span>
                            <p class="text-[10px] text-slate-300 mt-1">تمت مطابقة التشفير الأمني بنجاح. جاري استرجاع السجلات الحساسة للملف المستهدف...</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-slate-400 text-xs font-semibold mb-2 font-mono tracking-wider" for="agent-key">
                                <i class="fa-solid fa-fingerprint text-isa-gold ml-1"></i> INVESTIGATOR PASSKEY (كود الولوج الفيدرالي)
                            </label>
                            <input
                                 type="text"
                                 id="agent-key"
                                 name="account_code"                                
                                 class="w-full bg-isa-dark border border-slate-800 text-isa-gold placeholder-slate-700 rounded px-4 py-3 text-xs font-mono focus:outline-none focus:border-isa-gold/50 transition-all duration-300"
                                placeholder="ISA-••••-••••">
                        </div>
                        <div>
                            <label class="block text-slate-400 text-xs font-semibold mb-2">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                required
                                class="w-full bg-isa-dark border border-slate-800 text-isa-gold rounded px-4 py-3 text-xs">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" id="auth-btn"
                            class="w-full bg-isa-gold hover:bg-opacity-90 text-isa-dark font-bold py-3 px-4 rounded text-xs tracking-widest transition-all duration-300 border border-isa-gold font-mono">
                            بدء فك التشفير الآمن (DECRYPT CORE)
                        </button>
                    </div>
                </form>
            </div>

            <div class="mt-8 pt-4 border-t border-slate-800/60 flex justify-between items-center text-[9px] font-mono text-slate-500">
                <span>SECURITY LEVEL: 4 (CLASSIFIED OPERATIONS)</span>
                <span class="text-isa-gold">DEMO CODE: ISA-LEGEND-199</span>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 2. واجهة التحكم الرئاسية الموحدة (Dashboard SPA) -->
    <!-- ======================================================== -->
    <div id="dashboard-screen" class="hidden min-h-screen flex flex-col md:flex-row relative z-10">
        
        <!-- القائمة الجانبية الفاخرة (Sidebar) -->
        <aside id="sidebar" class="w-full md:w-64 bg-isa-navy border-l border-slate-800 flex flex-col justify-between z-20">
            <div>
                <!-- ترويسة القائمة الجانبية والشعار المصغر -->
                <div class="p-6 border-b border-slate-800 flex items-center gap-3">
                    <div class="w-7 h-7 text-isa-gold">
                        <svg viewBox="0 0 100 100" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-full h-full">
                            <circle cx="50" cy="50" r="45" stroke="currentColor" />
                            <polygon points="50,28 62,50 50,72 38,50" />
                        </svg>
                    </div>
                    <span class="font-bold text-white tracking-widest font-mono text-xs">ISA_CORE_DESK</span>
                </div>

                <!-- الروابط الاستخباراتية الرسمية والموثوقة -->
                <nav class="p-4 space-y-1">
                    <button onclick="switchTab('tab-mission-center', this)" class="w-full flex items-center justify-between px-4 py-3 text-xs font-bold rounded bg-isa-gold/5 text-isa-gold border-r-2 border-isa-gold transition-all nav-btn">
                        <span class="flex items-center gap-3">
                            <i class="fa-solid fa-compass w-5 text-center"></i> مركز العمليات الاستراتيجية
                        </span>
                        <span class="font-mono text-[9px]">[01]</span>
                    </button>
                    <button onclick="switchTab('tab-profile-stats', this)" class="w-full flex items-center justify-between px-4 py-3 text-xs font-bold rounded text-slate-400 hover:text-isa-gold hover:bg-slate-800/40 transition-all nav-btn">
                        <span class="flex items-center gap-3">
                            <i class="fa-solid fa-user-tie w-5 text-center"></i> بطاقة المحقق الخاص
                        </span>
                        <span class="font-mono text-[9px]">[02]</span>
                    </button>
                    <button onclick="switchTab('tab-case-files', this)" class="w-full flex items-center justify-between px-4 py-3 text-xs font-bold rounded text-slate-400 hover:text-isa-gold hover:bg-slate-800/40 transition-all nav-btn">
                        <span class="flex items-center gap-3">
                            <i class="fa-solid fa-box-archive w-5 text-center"></i> سجلات القضايا النشطة
                        </span>
                        <span class="font-mono text-[9px]">[03]</span>
                    </button>
                    <button onclick="switchTab('tab-investigation-portal', this)" class="w-full flex items-center justify-between px-4 py-3 text-xs font-bold rounded text-slate-400 hover:text-isa-gold hover:bg-slate-800/40 transition-all nav-btn">
                        <span class="flex items-center gap-3">
                            <i class="fa-solid fa-gavel w-5 text-center"></i> منصة التحقيق وتقديم الأدلة
                        </span>
                        <span class="font-mono text-[9px]">[04]</span>
                    </button>
                    <button onclick="switchTab('tab-archive-history', this)" class="w-full flex items-center justify-between px-4 py-3 text-xs font-bold rounded text-slate-400 hover:text-isa-gold hover:bg-slate-800/40 transition-all nav-btn">
                        <span class="flex items-center gap-3">
                            <i class="fa-solid fa-book-open-reader w-5 text-center"></i> الأرشيف الفيدرالي المغلق
                        </span>
                        <span class="font-mono text-[9px]">[05]</span>
                    </button>
                    <button onclick="switchTab('tab-isa-database', this)" class="w-full flex items-center justify-between px-4 py-3 text-xs font-bold rounded text-slate-400 hover:text-isa-gold hover:bg-slate-800/40 transition-all nav-btn">
                        <span class="flex items-center gap-3">
                            <i class="fa-solid fa-server w-5 text-center"></i> قاعدة البيانات الاستخباراتية
                        </span>
                        <span class="font-mono text-[9px]">[06]</span>
                    </button>
                    <button onclick="switchTab('tab-shadow-section', this)" class="w-full flex items-center justify-between px-4 py-3 text-xs font-bold rounded text-slate-400 hover:text-red-400 hover:bg-isa-burgundy/10 transition-all nav-btn">
                        <span class="flex items-center gap-3">
                            <i class="fa-solid fa-eye-slash w-5 text-center text-red-500"></i> ملفات منظمة "Shadow"
                        </span>
                        <span class="font-mono text-[9px] text-red-400 animate-pulse">[07]</span>
                    </button>
                </nav>
            </div>

            <!-- معلومات العميل الحالية وزر الخروج -->
            <div class="p-4 border-t border-slate-800 space-y-3">
                <div class="flex items-center gap-3 p-2 bg-isa-dark border border-slate-800/80">
                    <div class="w-9 h-9 rounded bg-slate-800 flex items-center justify-center text-isa-gold font-bold border border-slate-700 font-mono text-xs">
                        AG-1
                    </div>
                    <div>
                        <div class="text-[9px] text-slate-500 font-mono uppercase">INVESTIGATOR BA:</div>
                        <div class="text-xs font-bold text-slate-200 font-mono" id="client-badge">ISA-LEGEND-199</div>
                    </div>
                </div>
                <button onclick="triggerLogout()" class="w-full flex items-center justify-center gap-2 bg-isa-burgundy/10 hover:bg-isa-burgundy/25 border border-isa-burgundy/20 hover:border-isa-burgundy/40 text-red-400 py-2 rounded text-xs font-bold transition-all">
                    <i class="fa-solid fa-power-off"></i> تأمين الخروج الفوري
                </button>
            </div>
        </aside>

        <!-- المحتوى الرئيسي (Main Viewport) -->
        <main class="flex-1 flex flex-col min-h-screen overflow-y-auto">
            <!-- الهيدر العلوي الرصين -->
            <header class="bg-isa-navy/80 backdrop-blur-md border-b border-slate-800 p-4 sticky top-0 z-10 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-4 w-full sm:w-auto">
                    <button class="md:hidden text-slate-300 hover:text-isa-gold p-2" onclick="toggleSidebar()">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <div>
                        <h2 class="serif-title text-base font-bold text-white tracking-widest uppercase">
                            TACTICAL OPERATIONS CENTER // ACTIVE SHELL
                        </h2>
                        <p class="text-[10px] text-slate-500 font-mono mt-0.5">STATUS: CLASSIFIED DESKTOP GATEWAY // IP SECURITY PROTOCOLS ONLINE</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 text-xs font-mono">
                    <span class="flex items-center gap-1.5 bg-isa-emerald/20 text-isa-emeraldText border border-isa-emerald/30 px-2.5 py-1 rounded text-[10px]">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        CONFIDENTIAL CONNECTION
                    </span>
                    <span class="text-slate-500">CLASS: ELITE PROFILER</span>
                </div>
            </header>

            <!-- محتويات التبويبات المتجاوبة -->
            <div class="p-6 space-y-6 max-w-7xl mx-auto w-full flex-1">

                <!-- ========================================== -->
                <!-- [01] MISSION CENTER TAB -->
                <!-- ========================================== -->
                <div id="tab-mission-center" class="tab-content space-y-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        
                        <!-- التوجيه الرئاسي النشط (Primary Case Card) -->
                        <div class="lg:col-span-2 bg-isa-navy border border-slate-800 rounded-lg p-6 relative overflow-hidden flex flex-col justify-between min-h-[250px] executive-glow">
                            <div class="absolute -left-16 -top-16 w-40 h-40 bg-isa-gold/5 rounded-full blur-2xl"></div>
                            
                            <div class="flex items-start justify-between relative z-10">
                                <div>
                                    <span class="bg-isa-emerald/20 text-isa-emeraldText border border-isa-emerald/30 text-[9px] px-2.5 py-1 rounded font-bold uppercase font-mono">
                                        <i class="fa-solid fa-circle-check ml-1"></i> ACTIVE_DIRECTIVE
                                    </span>
                                    <h3 class="serif-title text-2xl font-bold text-white mt-4">المهمة الجارية: فك شفرة مقتل "فكتور بتروف"</h3>
                                    <p class="text-slate-400 text-xs mt-1">توجيه أمني استثنائي صادر عن الإدارة العامة لوكالة ISA.</p>
                                </div>
                                <span class="stamp-classified text-[10px] py-1 px-4">مستند رسمي مغلق</span>
                            </div>

                            <div class="border-t border-slate-800/80 pt-4 mt-6 text-xs relative z-10 space-y-3">
                                <p class="text-slate-300 leading-relaxed">
                                    "أيها المحقق الفاضل، لقد تم استدعاؤك شخصياً من فترة التقاعد لتولي هذا الملف الحرج بالذات. 
                                    فكتور بتروف الملقب بـ (التاجر البلطيقي) عُثر على جثته مقتولاً داخل شقته المغلقة كلياً من الداخل. 
                                    الأدلة المادية تم تغليفها وتسليمها إلى منزلك الآمن. استخدم كود فك التشفير المرفق لفك سجل البيانات الرقمي ومقارنة الأدلة وتقديم لائحة الاتهام الرسمية."
                                </p>
                                <div class="flex items-center gap-4 text-[10px] text-isa-gold font-mono pt-2">
                                    <span>الرمز التجريبي لفحص القضية: <strong class="bg-isa-dark px-2 py-0.5 rounded border border-slate-800">CASE-9921</strong></span>
                                </div>
                            </div>
                        </div>

                        <!-- نظام التواصل والرسائل الفيدرالية السريعة -->
                        <div class="bg-isa-navy border border-slate-800 rounded-lg p-6 flex flex-col justify-between executive-glow">
                            <div>
                                <span class="text-[10px] font-mono text-isa-gold tracking-widest block mb-4">ISA SECURE CABLES (الاتصالات الجارية)</span>
                                <div class="space-y-4">
                                    <!-- برقية 1 -->
                                    <div class="p-3 rounded bg-isa-dark border border-slate-800 text-xs">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="font-bold text-isa-gold text-[10px] font-mono">ISA HEADQUARTERS</span>
                                            <span class="text-[9px] text-slate-500 font-mono">14:02 UTC</span>
                                        </div>
                                        <p class="text-slate-400 leading-relaxed text-right">تم التحقق من بصمتك الرقمية. الملف الورقي الكامل للقضية تم تسليمه يدوياً إلى عنوانك الآمن.</p>
                                    </div>
                                    <!-- برقية 2 -->
                                    <div class="p-3 rounded bg-isa-dark border border-slate-800 text-xs">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="font-bold text-slate-400 text-[10px] font-mono">CYBER DIV (أمن الشبكات)</span>
                                            <span class="text-[9px] text-slate-500 font-mono">08:15 UTC</span>
                                        </div>
                                        <p class="text-slate-400 leading-relaxed text-right">تم رصد وتثبيط محاولة لتتبع مسار بروتوكول الإنترنت الخاص بجلسة العمل الحالية.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ========================================== -->
                <!-- [02] INVESTIGATOR PROFILE TAB -->
                <!-- ========================================== -->
                <div id="tab-profile-stats" class="tab-content hidden space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        <!-- الملف الشخصي للمحقق -->
                        <div class="bg-isa-navy border border-slate-800 rounded-lg p-6 flex flex-col items-center justify-center text-center executive-glow relative overflow-hidden">
                            <div class="absolute -right-12 -bottom-12 w-32 h-32 bg-isa-gold/5 rounded-full blur-2xl"></div>
                            
                            <div class="w-20 h-20 rounded-full bg-slate-900 border border-isa-gold flex items-center justify-center text-isa-gold text-3xl font-serif mb-4 shadow-xl">
                                V
                            </div>
                            <h4 class="serif-title text-xl font-bold text-white tracking-wide" id="profile-name-display">المحقق الأسطوري المتقاعد</h4>
                            <span class="text-[10px] font-mono text-isa-gold bg-isa-gold/5 border border-isa-gold/20 px-2.5 py-0.5 rounded mt-2" id="profile-rank">PROBATIONARY INVESTIGATOR</span>
                            
                            <div class="w-full grid grid-cols-2 gap-4 mt-8 pt-6 border-t border-slate-800/80 text-xs text-right">
                                <div>
                                    <span class="text-slate-500 block text-[9px] font-mono">AGENT ID:</span>
                                    <span class="text-slate-200 font-mono">#ISA-99120-LEG</span>
                                </div>
                                <div>
                                    <span class="text-slate-500 block text-[9px] font-mono">CLEARANCE STATUS:</span>
                                    <span class="text-slate-200 font-mono">LEVEL 4 // ACTIVE</span>
                                </div>
                            </div>
                        </div>

                        <!-- شبكة إحصائيات الدقة والعمليات -->
                        <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="bg-isa-navy border border-slate-800 rounded-lg p-6 flex flex-col justify-between executive-glow">
                                <span class="text-[10px] font-mono text-slate-500 uppercase tracking-wider">RESOLVED DIRECTIVES (القضايا المستكشفة)</span>
                                <div class="mt-4">
                                    <div class="text-3xl font-bold text-white font-mono" id="stats-solved">0 / 3</div>
                                    <p class="text-xs text-slate-400 mt-2 leading-relaxed">القضايا والجرائم الحالية والماضية التي نجحت في حل شفرتها وتحديد مرتكبها.</p>
                                </div>
                            </div>
                            <div class="bg-isa-navy border border-slate-800 rounded-lg p-6 flex flex-col justify-between executive-glow">
                                <span class="text-[10px] font-mono text-slate-500 uppercase tracking-wider">ACCURACY ACCREDITATION (نسبة الدقة القانونية)</span>
                                <div class="mt-4">
                                    <div class="text-3xl font-bold text-white font-mono" id="stats-accuracy">0.00%</div>
                                    <p class="text-xs text-slate-400 mt-2 leading-relaxed">نسبة دقة الاتهامات الموجهة من المرة الأولى ومطابقتها للأدلة الجنائية الصارمة.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ========================================== -->
                <!-- [03] ACTIVE CASES TAB -->
                <!-- ========================================== -->
                <div id="tab-case-files" class="tab-content hidden space-y-6">
                    <span class="text-[10px] font-mono text-isa-gold tracking-widest block uppercase">DOSSIER INDEX // SECURE INVESTIGATION ENTRIES</span>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        
                        <!-- قضية 1: مفتوحة -->
                        <div class="bg-isa-navy border border-slate-800 rounded-lg p-5 flex flex-col justify-between h-72 executive-glow relative">
                            <div>
                                <div class="flex items-start justify-between">
                                    <span class="bg-isa-emerald/20 text-isa-emeraldText border border-isa-emerald/30 text-[9px] px-2 py-0.5 rounded font-mono font-bold">UNLOCKED // ACTIVE</span>
                                    <span class="text-[10px] font-mono text-slate-500">REF: CASE-9921</span>
                                </div>
                                <h4 class="serif-title text-base font-bold text-white mt-4">ملف قضية: مقتل فكتور بتروف "Viktor Petrov"</h4>
                                <p class="text-xs text-slate-400 mt-2 leading-relaxed">عُثر على جثة تاجر الأسلحة غير المشروعة في شقته المغلقة بوسط المدينة. تفاصيل الجثة تشير إلى تسمم حاد في الدم وظروف مريبة.</p>
                            </div>
                            <div class="border-t border-slate-800/80 pt-4 flex items-center justify-between">
                                <span class="text-[10px] text-slate-500 font-mono">PASSKEY INPUT REQUIRED</span>
                                <button onclick="switchTab('tab-investigation-portal', null)" class="text-[11px] text-isa-gold font-bold hover:underline">افتح منصة التحقيق <i class="fa-solid fa-arrow-left"></i></button>
                            </div>
                        </div>

                        <!-- قضية 2: مغلقة -->
                        <div class="bg-isa-navy/50 border border-slate-800/60 rounded-lg p-5 flex flex-col justify-between h-72 relative opacity-60">
                            <div>
                                <div class="flex items-start justify-between">
                                    <span class="bg-isa-burgundy/10 text-red-400 border border-isa-burgundy/20 text-[9px] px-2 py-0.5 rounded font-mono font-bold">LOCKED // HIGH CLEARANCE</span>
                                    <span class="text-[10px] font-mono text-slate-500">REF: CASE-8841</span>
                                </div>
                                <h4 class="serif-title text-base font-bold text-slate-400 mt-4">ملف قضية: اختفاء رائد التشفير الفيدرالي</h4>
                                <p class="text-xs text-slate-500 mt-2 leading-relaxed">انقطع بث الاتصال الخاص بمدير الحسابات في الأمن القومي فجأة من داخل منزله الحصين. لا توجد أي بصمات ملموسة.</p>
                            </div>
                            <div class="border-t border-slate-800/40 pt-4 flex items-center justify-between text-[10px] text-slate-500">
                                <span>يتطلب حل القضية السابقة للفتح</span>
                                <i class="fa-solid fa-lock"></i>
                            </div>
                        </div>

                        <!-- قضية 3: مغلقة -->
                        <div class="bg-isa-navy/50 border border-slate-800/60 rounded-lg p-5 flex flex-col justify-between h-72 relative opacity-60">
                            <div>
                                <div class="flex items-start justify-between">
                                    <span class="bg-isa-burgundy/10 text-red-400 border border-isa-burgundy/20 text-[9px] px-2 py-0.5 rounded font-mono font-bold">LOCKED // HIGH CLEARANCE</span>
                                    <span class="text-[10px] font-mono text-slate-500">REF: CASE-0711</span>
                                </div>
                                <h4 class="serif-title text-base font-bold text-slate-400 mt-4">ملف قضية: الهجوم السيبراني على المفاعل المركزي</h4>
                                <p class="text-xs text-slate-500 mt-2 leading-relaxed">محاولة تخريب منشأة المفاعل الوطني عبر ملف فيروس متطور جداً تم رفعه محلياً من داخل نطاق الشبكة المعزولة.</p>
                            </div>
                            <div class="border-t border-slate-800/40 pt-4 flex items-center justify-between text-[10px] text-slate-500">
                                <span>يتطلب رتبة: SENIOR PROFILER</span>
                                <i class="fa-solid fa-lock"></i>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ========================================== -->
                <!-- [04] INVESTIGATION PORTAL & SUBMISSION -->
                <!-- ========================================== -->
                <div id="tab-investigation-portal" class="tab-content hidden space-y-6">
                    <span class="text-[10px] font-mono text-isa-gold tracking-widest block uppercase">CRIMINOLOGICAL ANALYSIS & DECRYPTION</span>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                        
                        <!-- القسم الأيمن: فك تشفير وتوجيه الاتهام -->
                        <div class="lg:col-span-7 space-y-6">
                            
                            <!-- إدخال الرمز السري من الملف الورقي -->
                            <div class="bg-isa-navy border border-slate-800 rounded-lg p-6 relative overflow-hidden">
                                <div class="absolute -right-20 -top-20 w-40 h-40 bg-isa-gold/5 rounded-full blur-2xl"></div>
                                <h4 class="serif-title text-base font-bold text-white mb-3 flex items-center gap-2">
                                    <i class="fa-solid fa-key text-isa-gold"></i> فك تشفير مستندات وأدلة القضية
                                </h4>
                                
                                <form id="decrypt-evidence-form" onsubmit="event.preventDefault(); triggerEvidenceDecryption();" class="space-y-4">
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
                                        <div class="sm:col-span-2">
                                            <label class="block text-slate-400 text-xs font-semibold mb-2 font-mono" for="case-input-code">CASE PASSCODE KEY</label>
                                            <input type="text" id="case-input-code" required
                                                class="w-full bg-isa-dark border border-slate-800 text-white placeholder-slate-700 rounded px-3 py-2 text-xs font-mono focus:outline-none focus:border-isa-gold/50 transition-colors"
                                                placeholder="CASE-XXXX">
                                        </div>
                                        <div>
                                            <button type="submit" id="decrypt-btn"
                                                class="w-full bg-isa-gold hover:bg-opacity-90 text-isa-dark font-bold py-2 px-3 rounded text-xs transition-colors border border-isa-gold">
                                                فك التشفير الآن
                                            </button>
                                        </div>
                                    </div>
                                    <p class="text-[10px] text-slate-500 font-mono"><i class="fa-solid fa-circle-info"></i> رموز فك التشفير تكون مدونة بشكل فيزيائي سري على الأوراق المستلمة خارج المنصة لتأمين الوصول.</p>
                                </form>
                            </div>

                            <!-- نموذج تقديم لائحة الاتهام الرسمية والنهائية للوكالة -->
                            <div class="bg-isa-navy border border-slate-800 rounded-lg p-6 relative">
                                <h4 class="serif-title text-base font-bold text-white mb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-gavel text-isa-gold"></i> لائحة الاتهام الرسمية وإصدار مذكرة التوقيف
                                </h4>
                                <p class="text-xs text-slate-400 mb-6">يجب مراجعة الأدلة والقرائن الطبية والمالية المفكوكة بدقة لتوجيه اتهام رسمي صحيح وإغلاق ملف القضية.</p>

                                <form id="accusation-form" onsubmit="event.preventDefault(); triggerAccusationVerify();" class="space-y-4 text-right">
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <!-- تحديد المشتبه به -->
                                        <div>
                                            <label class="block text-slate-400 text-xs font-semibold mb-2">المشتبه به الرئيسي</label>
                                            <select id="acc-suspect" required class="w-full bg-isa-dark border border-slate-800 text-slate-200 rounded px-3 py-2 text-xs focus:outline-none focus:border-isa-gold/50 transition-colors">
                                                <option value="">-- حدد المتهم --</option>
                                                <option value="petrov">فكتور بتروف (القتيل - انتحار)</option>
                                                <option value="viktor_partner">أوليفيا ميلر (شريكة أعمال بتروف)</option>
                                                <option value="shadow_agent">العميل المزدوج (من داخل الوكالة)</option>
                                            </select>
                                        </div>

                                        <!-- تحديد الدافع المالي أو الأمني -->
                                        <div>
                                            <label class="block text-slate-400 text-xs font-semibold mb-2">الدافع والظروف المحيطة</label>
                                            <select id="acc-motive" required class="w-full bg-isa-dark border border-slate-800 text-slate-200 rounded px-3 py-2 text-xs focus:outline-none focus:border-isa-gold/50 transition-colors">
                                                <option value="">-- حدد الدافع --</option>
                                                <option value="blackmail">الابتزاز والتصفية لمنع تسريب الوثائق</option>
                                                <option value="greed">الطمع في تحويلات الأرصدة البنكية المشفرة</option>
                                                <option value="accident">محاولة هروب فاشلة أدت إلى الوفاة</option>
                                            </select>
                                        </div>

                                        <!-- تحديد السلاح أو أداة الجريمة الحقيقية -->
                                        <div>
                                            <label class="block text-slate-400 text-xs font-semibold mb-2">أداة أو وسيلة الجريمة</label>
                                            <select id="acc-evidence" required class="w-full bg-isa-dark border border-slate-800 text-slate-200 rounded px-3 py-2 text-xs focus:outline-none focus:border-isa-gold/50 transition-colors">
                                                <option value="">-- حدد الدليل الجنائي --</option>
                                                <option value="cyanide">سم السيانيد الممزوج في مستودع القهوة</option>
                                                <option value="silencer">مسدس مزود بكاتم صوت عيار 9 ملم</option>
                                                <option value="overdose">جرعة دوائية زائدة مضافة قسراً</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="pt-4 border-t border-slate-800/80 flex justify-end">
                                        <button type="submit" id="acc-submit-btn"
                                            class="bg-isa-gold hover:bg-opacity-90 text-isa-dark font-bold py-2.5 px-6 rounded text-xs transition-colors border border-isa-gold">
                                            إرسال المذكرة الرسمية وتوثيق الإدانة
                                        </button>
                                    </div>

                                </form>
                            </div>

                        </div>

                        <!-- القسم الأيسر: الأدلة المفكوكة بعد التحقق -->
                        <div class="lg:col-span-5 bg-isa-navy border border-slate-800 rounded-lg p-6 relative">
                            <h4 class="serif-title text-base font-bold text-white mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-folder-open text-isa-gold"></i> الوثائق الجنائية والقرائن المفكوكة
                            </h4>
                            <p class="text-xs text-slate-400 mb-4">تظهر هنا التقارير والمكالمات تلقائياً بمجرد إدخال كود فك التشفير بنجاح.</p>
                            
                            <div id="unlocked-evidence-list" class="space-y-3">
                                <!-- الحالة المقفلة بشكل افتراضي -->
                                <div id="evidence-locked-placeholder" class="text-center py-12 text-slate-500 border border-dashed border-slate-800 rounded bg-isa-dark/40">
                                    <i class="fa-solid fa-lock text-3xl mb-3 text-slate-700"></i>
                                    <p class="text-xs leading-relaxed">السجلات الجنائية الطبية والمالية مغلقة حالياً.<br>أدخل رمز فك التشفير للمصادقة وعرض البيانات.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ========================================== -->
                <!-- [05] ARCHIVE TAB -->
                <!-- ========================================== -->
                <div id="tab-archive-history" class="tab-content hidden space-y-6">
                    <span class="text-[10px] font-mono text-isa-gold tracking-widest block uppercase">DECLASSIFIED LOGS & INVESTIGATION LEDGER</span>
                    
                    <div class="bg-isa-navy border border-slate-800 rounded-lg p-6">
                        <h4 class="serif-title text-lg font-bold text-white mb-4">سجل القضايا والعمليات السابقة المغلقة بالكامل</h4>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-right text-xs">
                                <thead>
                                    <tr class="border-b border-slate-800 text-slate-500 uppercase font-mono">
                                        <th class="pb-3">القضية الأرشيفية</th>
                                        <th class="pb-3">المحقق الفيدرالي</th>
                                        <th class="pb-3">تاريخ إغلاق الملف</th>
                                        <th class="pb-3 text-left">تصنيف السرية</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-800/50" id="archive-table-body">
                                    <tr class="hover:bg-slate-800/10">
                                        <td class="py-4 font-bold text-slate-300">قضية تفجير مستودع الشحن البحري رقم 4</td>
                                        <td class="py-4 font-mono text-slate-400">ISA-LEGEND-199 (أنت)</td>
                                        <td class="py-4 text-slate-400">14 مايو 2024</td>
                                        <td class="py-4 text-left font-mono text-isa-gold">LEVEL 3 // ARCHIVED</td>
                                    </tr>
                                    <tr class="hover:bg-slate-800/10">
                                        <td class="py-4 font-bold text-slate-300">تصفية القناص الأجنبي بضواحي العاصمة</td>
                                        <td class="py-4 font-mono text-slate-400">ISA-LEGEND-199 (أنت)</td>
                                        <td class="py-4 text-slate-400">01 يناير 2023</td>
                                        <td class="py-4 text-left font-mono text-isa-gold">LEVEL 3 // ARCHIVED</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- [06] ISA DATABASE TAB -->
                <!-- ========================================== -->
                <div id="tab-isa-database" class="tab-content hidden space-y-6">
                    <span class="text-[10px] font-mono text-isa-gold tracking-widest block uppercase">ISA SECURE MAINFRAME DIRECTORIES</span>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="bg-isa-navy border border-slate-800 rounded-lg p-6 flex flex-col justify-between h-72 executive-glow relative">
                            <div>
                                <div class="flex items-start justify-between">
                                    <span class="bg-isa-burgundy/10 text-red-400 border border-isa-burgundy/20 text-[9px] px-2 py-0.5 rounded font-mono font-bold">LOCKED // CLASS 5 CLEARANCE</span>
                                    <span class="text-[10px] font-mono text-slate-500">REF: DATA-SHIELD-X</span>
                                </div>
                                <h4 class="serif-title text-lg font-bold text-white mt-4">تقارير التنصت وسجلات المكالمات الهاتفية الفيدرالية</h4>
                                <p class="text-xs text-slate-400 mt-2 leading-relaxed">تفريغات صوتية مسجلة من غرف تتبع المتهمين في ملفات الأمن القومي. تتضمن تسجيلات منسوبة لمشتبهين في مجلس قضاء سطيف.</p>
                            </div>
                            <div class="border-t border-slate-800/80 pt-4 flex items-center justify-between text-slate-500 text-[10px]">
                                <span>الوصول مقتصر على الرتب العليا</span>
                                <i class="fa-solid fa-lock text-red-500 animate-pulse"></i>
                            </div>
                        </div>

                        <div class="bg-isa-navy border border-slate-800 rounded-lg p-6 flex flex-col justify-between h-72 executive-glow relative">
                            <div>
                                <div class="flex items-start justify-between">
                                    <span class="bg-isa-burgundy/10 text-red-400 border border-isa-burgundy/20 text-[9px] px-2 py-0.5 rounded font-mono font-bold">LOCKED // CLASS 5 CLEARANCE</span>
                                    <span class="text-[10px] font-mono text-slate-500">REF: WIRE-TAP-02</span>
                                </div>
                                <h4 class="serif-title text-lg font-bold text-white mt-4">تقارير التشريح الجنائي والأدلة الجينية المسحوبة</h4>
                                <p class="text-xs text-slate-400 mt-2 leading-relaxed">قاعدة البيانات الطبية الحيوية المشتركة بين المستشفى العسكري ومخابرات الـ ISA. تحتوي تحليلات السموم الرقمية لآخر القضايا المغلقة.</p>
                            </div>
                            <div class="border-t border-slate-800/80 pt-4 flex items-center justify-between text-slate-500 text-[10px]">
                                <span>الوصول مقتصر على الرتب العليا</span>
                                <i class="fa-solid fa-lock text-red-500 animate-pulse"></i>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ========================================== -->
                <!-- [07] SHADOW FILES TAB (Progressive Unlock) -->
                <!-- ========================================== -->
                <div id="tab-shadow-section" class="tab-content hidden space-y-6">
                    <span class="text-[10px] font-mono text-red-500 tracking-widest block uppercase">RESTRICTED_FOLDER_RECOVERY // CRITICAL</span>
                    
                    <div class="bg-isa-navy border border-isa-burgundy/30 rounded-lg p-6 relative overflow-hidden">
                        <!-- تدرج لوني أحمر ناعم جداً خلف الكارت لمحاكاة الخطورة -->
                        <div class="absolute -left-16 -top-16 w-40 h-40 bg-isa-burgundy/5 rounded-full blur-2xl"></div>
                        
                        <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-6 relative z-10">
                            <div>
                                <h4 class="serif-title text-xl font-bold text-white flex items-center gap-2">
                                    <i class="fa-solid fa-user-ninja text-red-500"></i> ملفات منظمة "The Shadow" (العميل المزدوج)
                                </h4>
                                <p class="text-[10px] text-slate-500 font-mono mt-1">RECOVERY_STATUS_SECTOR // DECRYPTION_PROGRESS: <span id="shadow-percentage" class="text-red-500">0.05%</span></p>
                            </div>
                            <span class="text-[10px] text-slate-500 font-mono">STATUS: CORRUPTED</span>
                        </div>

                        <!-- المحتوى الديناميكي المتغير بناء على حل القضية -->
                        <div id="shadow-viewport" class="space-y-4 relative z-10 text-xs text-slate-450 leading-relaxed text-right">
                            
                            <!-- محتوى مقفل بشكل افتراضي -->
                            <div class="text-center py-12 text-slate-500" id="shadow-locked-ui">
                                <i class="fa-solid fa-shield-virus text-4xl mb-4 text-isa-burgundy/40"></i>
                                <p class="text-xs leading-relaxed">البيانات والملفات تالفة أو تمت تصفيتها عمداً لمنع كشف العميل المزدوج.<br>يتطلب حل قضايا تصفية الحسابات النشطة لربط مصفوفات الاسترجاع تلقائياً.</p>
                            </div>

                            <!-- السجلات والوثائق المكشوفة بعد الإدانة الناجحة -->
                            <div id="shadow-unlocked-ui" class="hidden space-y-4">
                                <div class="p-4 bg-isa-dark rounded border border-isa-burgundy/20">
                                    <div class="flex justify-between items-center mb-2 font-mono text-[9px] text-red-400">
                                        <span>RECOVERED_RECORD_001</span>
                                        <span>RESTRICTED // CLASSIFIED</span>
                                    </div>
                                    <p class="text-slate-300 leading-relaxed">
                                        <strong>مراسلة سرية مسربة من مكتب رئيس الوكالة:</strong> 
                                        "نعتقد جازمين أن منظمة (Shadow) قد نجحت في تجنيد وتثبيت عميل مزدوج برتبة رفيعة جداً داخل الإدارة الوسطى لوكالة ISA. العميل مسؤول عن إتلاف السجلات الرقمية للجرائم المغلقة ومطابقتها. لا تثقوا بأي تقارير تصفية حسابات صادرة من الخوادم المركزية دون تدقيق خارجي..."
                                    </p>
                                </div>
                                <div class="p-4 bg-isa-dark rounded border border-isa-burgundy/20">
                                    <div class="flex justify-between items-center mb-2 font-mono text-[9px] text-red-400">
                                        <span>RECOVERED_CABLE_902</span>
                                        <span>WIRETAP_TRANSCRIPT</span>
                                    </div>
                                    <p class="text-slate-300 leading-relaxed">
                                        <strong>تفريغ مكالمة هاتفية معترضة:</strong> 
                                        "...تأكدوا من غلق التحقيق في قضية بتروف وإلصاق الأمر بشخص خارجي. المحقق المتقاعد الذي استعانت به الوكالة قد يشكل خطراً حقيقياً إذا تمكن من فك شفرة الأدلة الورقية التي نسينا حرقها..."
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- إشعارات التنزيل والإرسال الفاخرة (Toast) -->
    <div id="download-toast" class="fixed bottom-6 right-6 bg-isa-navy border border-slate-800 px-5 py-3.5 rounded shadow-2xl flex items-center gap-3 transform translate-y-24 opacity-0 transition-all duration-300 ease-out z-50">
        <div class="w-8 h-8 rounded bg-isa-goldMuted text-isa-gold flex items-center justify-center">
            <i class="fa-solid fa-spinner animate-spin"></i>
        </div>
        <div>
            <h6 class="text-xs font-bold text-white" id="toast-title">جاري التنزيل والتحقق...</h6>
            <p class="text-[10px] text-slate-500 mt-0.5" id="toast-filename"></p>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- 3. المحرك البرمجي وحفظ الحالة (JavaScript) -->
    <!-- ======================================================== -->
    <script>
        // إعدادات وبيانات الحالة للمنصة
        const SYSTEM_STATE = {
            authenticated: false,
            agentKey: 'ISA-LEGEND-199',
            correctCaseCode: 'CASE-9921',
            isCaseDecrypted: false,
            solvedCount: 0,
            totalCases: 3,
            attempts: 0,
            successAttempts: 0,
            accuracy: 0.00,
            shadowPercentage: 0.05
        };

        // قائمة الأدلة الحقيقية والقرائن التي تظهر بعد فك التشفير
        const ForensicEvidence = [
            { id: 'ev-1', icon: 'fa-file-signature', type: 'مذكرة قضائية', title: 'وثيقة تصفية الحسابات المالية المشبوهة', desc: 'تم استرجاع مستند مالي ممزق من سلة نفايات القتيل، يحمل توقيع أوليفيا ميلر وبتروف، يؤكد وجود خلاف مالي بقيمة ملايين الدولارات.' },
            { id: 'ev-2', icon: 'fa-vial', type: 'تقرير السموم الجنائية', title: 'تقرير تشريح عينات الدم لبتروف', desc: 'يؤكد تقرير مختبر السموم العسكري وجود كميات عالية من سم السيانيد المركز ممتزجة في كوب القهوة المتروك على طاولة الضحية.' },
            { id: 'ev-3', icon: 'fa-key', type: 'أمن المنشآت', title: 'سجل دخول الشقة المشفر', desc: 'تم العثور على بطاقة دخول مشفرة لأمن الوكالة سقطت أسفل مدخل شقة القتيل، مما يثبت تغلغل عملاء منظمة الـ Shadow في مسرح الجريمة.' }
        ];

        // 1. معالجة التحقق والدخول الرصين (ISA Secure Handshake)
        function handleSecureHandshake() {
            const keyInput = document.getElementById('agent-key').value.trim();
            const authCard = document.getElementById('auth-card');
            const errorDiv = document.getElementById('auth-error');
            const successDiv = document.getElementById('auth-success');
            const submitBtn = document.getElementById('auth-btn');

            errorDiv.classList.add('hidden');
            successDiv.classList.add('hidden');
            authCard.classList.remove('shake-trigger', 'border-isa-burgundy');
            document.getElementById('agent-key').classList.remove('border-isa-burgundy');

            if (keyInput === SYSTEM_STATE.agentKey) {
                // تفعيل حالة التحميل الرصينة والوقورة
                submitBtn.disabled = true;
                submitBtn.textContent = "VERIFYING SECURITY DECRYPTION...";

                setTimeout(() => {
                    successDiv.classList.remove('hidden');
                }, 800);

                setTimeout(() => {
                    document.getElementById('auth-screen').classList.add('hidden');
                    document.getElementById('dashboard-screen').classList.remove('hidden');
                    SYSTEM_STATE.authenticated = true;
                    updateUI();
                }, 2200);
            } else {
                // حالة الفشل: اهتزاز فيزيائي خفيف وتحويل الحدود للون الأحمر الصارم
                setTimeout(() => {
                    authCard.classList.add('shake-trigger', 'border-isa-burgundy');
                    document.getElementById('agent-key').classList.add('border-isa-burgundy');
                    errorDiv.classList.remove('hidden');
                    document.getElementById('agent-key').value = "";
                }, 50);

                setTimeout(() => {
                    authCard.classList.remove('shake-trigger');
                }, 450);
            }
        }

        // 2. معالجة تصفح التبويبات بالـ SPA Shell
        function switchTab(tabId, buttonElement) {
            // إخفاء كل التبويبات
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
            
            // إظهار التبويب المحدد
            document.getElementById(tabId).classList.remove('hidden');

            // إعادة ضبط أزرار القائمة الجانبية
            if (buttonElement) {
                document.querySelectorAll('.nav-btn').forEach(btn => {
                    btn.classList.remove('bg-isa-gold/5', 'text-isa-gold', 'border-r-2', 'border-isa-gold');
                    btn.classList.add('text-slate-400');
                });
                // تفعيل المظهر النشط للزر الحالي
                buttonElement.classList.add('bg-isa-gold/5', 'text-isa-gold', 'border-r-2', 'border-isa-gold');
                buttonElement.classList.remove('text-slate-400');
            }

            // إغلاق القائمة تلقائياً على شاشات الجوال
            if (window.innerWidth < 768) {
                document.getElementById('sidebar').classList.add('hidden');
            }
        }

        // 3. فك تشفير مستندات وأدلة القضية
        function triggerEvidenceDecryption() {
            const codeInput = document.getElementById('case-input-code').value.trim();
            const decryptBtn = document.getElementById('decrypt-btn');
            
            if (codeInput === SYSTEM_STATE.correctCaseCode) {
                decryptBtn.disabled = true;
                decryptBtn.textContent = "DECRYPTING...";

                setTimeout(() => {
                    SYSTEM_STATE.isCaseDecrypted = true;
                    decryptBtn.textContent = "COMPLETED ✓";
                    renderUnlockedEvidence();
                    showNotificationToast("تم التحقق بنجاح", "تم فك تشفير ملفات تشريح جثة فكتور بتروف #CASE-9921 بنجاح.");
                }, 1500);
            } else {
                showNotificationToast("كود التشفير غير مطابق", "مفتاح فك التشفير المدخل غير مصرح به لتجاوز هذا الملف السري.", true);
                document.getElementById('case-input-code').value = "";
            }
        }

        // بناء وعرض الأدلة والوثائق فور فك التشفير
        function renderUnlockedEvidence() {
            const listContainer = document.getElementById('unlocked-evidence-list');
            const placeholder = document.getElementById('evidence-locked-placeholder');

            if (!SYSTEM_STATE.isCaseDecrypted) {
                placeholder.classList.remove('hidden');
                return;
            }

            placeholder.classList.add('hidden');
            listContainer.querySelectorAll('.evidence-card').forEach(el => el.remove());

            ForensicEvidence.forEach(item => {
                const card = document.createElement('div');
                card.className = "evidence-card p-4 bg-isa-dark border border-slate-800 rounded flex gap-4 hover:border-isa-gold/30 transition-all duration-300";
                card.innerHTML = `
                    <div class="w-10 h-10 rounded bg-isa-goldMuted text-isa-gold flex items-center justify-center text-lg shrink-0 border border-isa-gold/10">
                        <i class="fa-solid ${item.icon}"></i>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-[9px] font-mono text-isa-gold bg-isa-goldMuted px-1.5 py-0.2 rounded">${item.type}</span>
                            <h5 class="text-xs font-bold text-slate-200">${item.title}</h5>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1 leading-relaxed">${item.desc}</p>
                    </div>
                `;
                listContainer.appendChild(card);
            });
        }

        // 4. محرك مراجعة ومطابقة لائحة الاتهام
        function triggerAccusationVerify() {
            const suspect = document.getElementById('acc-suspect').value;
            const motive = document.getElementById('acc-motive').value;
            const evidence = document.getElementById('acc-evidence').value;
            const submitBtn = document.getElementById('acc-submit-btn');

            if (!SYSTEM_STATE.isCaseDecrypted) {
                showNotificationToast("خطأ أمني فني", "يجب أولاً إدخال كود فك التشفير لمراجعة مستندات القضية والأدلة قبل توجيه الاتهامات.", true);
                return;
            }

            submitBtn.disabled = true;
            submitBtn.textContent = "VERIFYING PROOFS...";

            setTimeout(() => {
                SYSTEM_STATE.attempts++;
                
                // تركيبة الاتهام الصحيحة: شريكة الأعمال أوليفيا ميلر قتلت بتروف بدافع الطمع المالي بالسيانيد
                if (suspect === 'viktor_partner' && motive === 'greed' && evidence === 'cyanide') {
                    SYSTEM_STATE.successAttempts++;
                    SYSTEM_STATE.solvedCount = 1;
                    SYSTEM_STATE.shadowPercentage = 45.85; // تفعيل استعادة جزئية لملفات الـ Shadow
                    
                    showNotificationToast("تم تأكيد الإدانة وإغلاق القضية!", "أوليفيا ميلر أُدينت رسمياً بتسميم القهوة بدافع الطمع المالي بالاستناد للقرائن.");
                    
                    // تحديث الحالة وعرض مستندات الظل
                    updateUI();
                    renderShadowContent();
                    appendCaseToArchive();
                } else {
                    showNotificationToast("فشل توجيه الاتهام", "الأدلة والقرائن المختارة غير متناسقة لدعم الاتهام الفيدرالي في المحكمة الجنائية.", true);
                }
                
                // حساب نسبة الدقة الاستقصائية للعميل
                SYSTEM_STATE.accuracy = (SYSTEM_STATE.successAttempts / SYSTEM_STATE.attempts) * 100;
                updateUI();
                submitBtn.disabled = false;
                submitBtn.textContent = "إرسال المذكرة الرسمية وتوثيق الإدانة";
            }, 1800);
        }

        // إضافة القضية المغلقة لجدول الأرشيف الفيدرالي
        function appendCaseToArchive() {
            const tableBody = document.getElementById('archive-table-body');
            const newRow = document.createElement('tr');
            newRow.className = "hover:bg-slate-800/10 font-mono text-xs";
            newRow.innerHTML = `
                <td class="py-4 font-bold text-slate-300 font-sans">قضية مقتل فكتور بتروف "Viktor Petrov"</td>
                <td class="py-4 text-slate-400">ISA-LEGEND-199 (أنت)</td>
                <td class="py-4 text-slate-400">اليوم (سجل فوري)</td>
                <td class="py-4 text-left text-isa-gold font-bold">SOLVED // ARCHIVED</td>
            `;
            tableBody.prepend(newRow);
        }

        // عرض تفاصيل الـ Shadow المكتشفة تدريجياً
        function renderShadowContent() {
            const lockedUI = document.getElementById('shadow-locked-ui');
            const unlockedUI = document.getElementById('shadow-unlocked-ui');
            
            if (SYSTEM_STATE.solvedCount > 0) {
                lockedUI.classList.add('hidden');
                unlockedUI.classList.remove('hidden');
            } else {
                lockedUI.classList.remove('hidden');
                unlockedUI.classList.add('hidden');
            }
        }

        // تحديث إحصائيات لوحة التحكم بالبيانات الجديدة
        function updateUI() {
            document.getElementById('stats-solved').textContent = `${SYSTEM_STATE.solvedCount} / ${SYSTEM_STATE.totalCases}`;
            document.getElementById('stats-accuracy').textContent = `${SYSTEM_STATE.accuracy.toFixed(2)}%`;
            document.getElementById('shadow-percentage').textContent = `${SYSTEM_STATE.shadowPercentage.toFixed(2)}%`;
            
            // تغيير الرتبة الاستخباراتية بشكل وقور
            const rankLabel = document.getElementById('profile-rank');
            if (SYSTEM_STATE.solvedCount === 0) {
                rankLabel.textContent = "PROBATIONARY INVESTIGATOR";
            } else if (SYSTEM_STATE.solvedCount === 1) {
                rankLabel.textContent = "SENIOR PROFILER // CLASS 4";
                rankLabel.classList.remove('text-isa-gold');
                rankLabel.classList.add('text-isa-emeraldText');
            }
        }

        // إشعارات وتنبيهات السيستم الفاخرة (Toast UI)
        function showNotificationToast(title, description, isError = false) {
            const toast = document.getElementById('download-toast');
            const toastTitle = document.getElementById('toast-title');
            const toastDesc = document.getElementById('toast-filename');
            const toastIcon = toast.querySelector('i');

            toastTitle.textContent = title;
            toastDesc.textContent = description;

            if (isError) {
                toast.classList.remove('border-slate-800');
                toast.classList.add('border-isa-burgundy', 'bg-isa-burgundy/10');
                toastIcon.className = "fa-solid fa-circle-exclamation text-red-500";
            } else {
                toast.classList.add('border-slate-800');
                toast.classList.remove('border-isa-burgundy', 'bg-isa-burgundy/10');
                toastIcon.className = "fa-solid fa-circle-check text-isa-gold";
            }

            toast.classList.remove('translate-y-24', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');

            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-24', 'opacity-0');
            }, 5000);
        }

        // تصفية البحث الفوري داخل الـ Dashboard
        function searchInDashboard() {
            const query = document.getElementById('dashboard-search').value.toLowerCase().trim();

            const docCards = document.querySelectorAll('.document-card');
            docCards.forEach(card => {
                const title = card.querySelector('.document-title').textContent.toLowerCase();
                card.style.display = title.includes(query) ? 'flex' : 'none';
            });

            const tableRows = document.querySelectorAll('.table-row-item');
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? 'table-row' : 'none';
            });
        }

        // الخروج وإعادة تشفير البيانات
        function triggerLogout() {
            SYSTEM_STATE.authenticated = false;
            SYSTEM_STATE.isCaseDecrypted = false;
            SYSTEM_STATE.solvedCount = 0;
            SYSTEM_STATE.attempts = 0;
            SYSTEM_STATE.successAttempts = 0;
            SYSTEM_STATE.accuracy = 0;
            SYSTEM_STATE.shadowPercentage = 0.05;

            document.getElementById('agent-key').value = "";
            document.getElementById('case-input-code').value = "";
            document.getElementById('decrypt-btn').disabled = false;
            document.getElementById('decrypt-btn').textContent = "فك التشفير الآن";
            document.getElementById('accusation-form').reset();
            
            renderUnlockedEvidence();
            renderShadowContent();
            updateUI();

            const authBtn = document.getElementById('auth-btn');
            authBtn.disabled = false;
            authBtn.textContent = "بدء فك التشفير الآمن (DECRYPT CORE)";
            document.getElementById('auth-success').classList.add('hidden');
            document.getElementById('auth-error').classList.add('hidden');

            document.getElementById('dashboard-screen').classList.add('hidden');
            document.getElementById('auth-screen').classList.remove('hidden');
        }

        // تفعيل همبرغر القائمة الجانبية للهاتف
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
        }
    </script>
</body>
</html>
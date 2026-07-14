import type React from "react"

interface LightGradientBackgroundProps {
  children?: React.ReactNode
  className?: string
}

export function LightGradientBackground({ children, className = "" }: LightGradientBackgroundProps) {
  return (
    <div className={`relative min-h-screen w-full overflow-hidden ${className}`}>
      {/* Main gradient background */}
      <div
        className="absolute inset-0 bg-gradient-to-b from-slate-50 via-white to-blue-50"
        style={{
          background: "linear-gradient(180deg, #ffffff 0%, #f8fafc 20%, #f1f5f9 40%, #dbeafe 70%, #eff6ff 100%)",
        }}
      />

      <div
        className="absolute inset-0 opacity-[0.03] bg-repeat"
        style={{
          backgroundImage: 'url("https://framerusercontent.com/images/6mcf62RlDfRfU61Yg5vb2pefpi4.png")',
          backgroundSize: '149.76px'
        }}
      />

      {/* Geometric grid overlay */}
      <div
        className="absolute inset-0"
        style={{
          backgroundImage: `
            linear-gradient(rgba(15,23,42,0.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(15,23,42,0.04) 1px, transparent 1px)
          `,
          backgroundSize: "60px 60px",
        }}
      />

      {/* Diagonal lines overlay for additional texture */}
      <div
        className="absolute inset-0"
        style={{
          backgroundImage: `
            linear-gradient(45deg, rgba(15,23,42,0.03) 1px, transparent 1px),
            linear-gradient(-45deg, rgba(15,23,42,0.03) 1px, transparent 1px)
          `,
          backgroundSize: "40px 40px",
        }}
      />

      {/* Content */}
      <div className="relative z-10">{children}</div>
    </div>
  )
}

import os
import re
from fpdf import FPDF

class StatusPDF(FPDF):
    def header(self):
        # Draw top accent bar (crimson red)
        self.set_fill_color(220, 38, 24)
        self.rect(0, 0, 210, 4, 'F')
        
    def footer(self):
        self.set_y(-15)
        self.set_font('helvetica', 'I', 8)
        self.set_text_color(128, 128, 128)
        self.cell(0, 10, f'Page {self.page_no()}', 0, 0, 'C')

def generate_pdf():
    pdf = StatusPDF()
    pdf.add_page()
    pdf.set_auto_page_break(auto=True, margin=15)
    
    # Title
    pdf.set_font('helvetica', 'B', 18)
    pdf.set_text_color(14, 27, 48) # Navy Blue
    pdf.multi_cell(0, 10, "C11CL Live Site & Panel\nProject Status Report", align='L')
    pdf.ln(4)
    
    # Subtitle / Info
    pdf.set_font('helvetica', '', 10)
    pdf.set_text_color(100, 100, 100)
    pdf.cell(0, 5, "Date: June 24, 2026", new_x="LMARGIN", new_y="NEXT")
    pdf.ln(8)
    
    # Divider line
    pdf.set_draw_color(220, 220, 220)
    pdf.line(10, pdf.get_y(), 200, pdf.get_y())
    pdf.ln(8)
    
    # Read Markdown
    md_path = 'project_status.md'
    if not os.path.exists(md_path):
        md_path = 'docs/project_status.md'
        
    if not os.path.exists(md_path):
        print(f"Error: {md_path} not found.")
        return
        
    with open(md_path, 'r', encoding='utf-8') as f:
        content = f.read()
        
    lines = content.split('\n')
    
    for line in lines:
        line = line.strip()
        if not line:
            continue
            
        # Title in markdown (already outputted custom title)
        if line.startswith('# ') or line.startswith('---'):
            continue
            
        # Section Heading
        elif line.startswith('## '):
            title = line.replace('## ', '').replace('──', '').strip()
            pdf.ln(5)
            pdf.set_font('helvetica', 'B', 12)
            if "Completed" in title:
                pdf.set_text_color(34, 139, 34) # Forest Green
            else:
                pdf.set_text_color(220, 38, 24) # Crimson Red
            pdf.cell(0, 8, title, new_x="LMARGIN", new_y="NEXT")
            pdf.ln(2)
            
        # Bullet Point
        elif line.startswith('*') or line.startswith('-'):
            # Check status
            is_completed = '✅' in line
            is_pending = '⏰' in line
            
            # Clean text
            clean_text = line
            clean_text = re.sub(r'^[\*\-\s]+', '', clean_text)
            clean_text = clean_text.replace('✅', '').replace('⏰', '').strip()
            
            # Draw custom bullet indicator
            curr_y = pdf.get_y()
            if is_completed:
                # Draw green checkmark box
                pdf.set_fill_color(220, 245, 220)
                pdf.set_draw_color(34, 139, 34)
                pdf.rect(12, curr_y + 1, 4, 4, 'DF')
                
                # Check icon (draw short line segment)
                pdf.line(13, curr_y + 3, 14, curr_y + 4)
                pdf.line(14, curr_y + 4, 15.5, curr_y + 1.5)
            elif is_pending:
                # Draw orange clock circle
                pdf.set_fill_color(255, 235, 204)
                pdf.set_draw_color(255, 140, 0)
                pdf.ellipse(12, curr_y + 1, 4, 4, 'DF')
                
                # Draw hands
                pdf.line(14, curr_y + 3, 14, curr_y + 2)
                pdf.line(14, curr_y + 3, 15, curr_y + 3)
            else:
                # Standard bullet
                pdf.set_fill_color(100, 100, 100)
                pdf.ellipse(13, curr_y + 2, 2, 2, 'F')
                
            pdf.set_x(20)
            
            # Format text: check for bold parts
            # **Bold**: text
            bold_match = re.match(r'^\*\*(.*?)\*\*:(.*)', clean_text)
            if bold_match:
                bold_part = bold_match.group(1).strip() + ":"
                normal_part = bold_match.group(2).strip()
                
                pdf.set_font('helvetica', 'B', 10)
                pdf.set_text_color(14, 27, 48)
                pdf.write(5, bold_part + " ")
                
                pdf.set_font('helvetica', '', 10)
                pdf.set_text_color(60, 60, 60)
                pdf.multi_cell(0, 5, normal_part)
            else:
                pdf.set_font('helvetica', '', 10)
                pdf.set_text_color(60, 60, 60)
                pdf.multi_cell(0, 5, clean_text)
                
            pdf.ln(3)
        else:
            # Regular text paragraph
            pdf.set_font('helvetica', 'I', 10)
            pdf.set_text_color(80, 80, 80)
            pdf.multi_cell(0, 5, line)
            pdf.ln(4)
            
    pdf.output('docs/project_status.pdf')
    print("PDF generated successfully")

if __name__ == '__main__':
    generate_pdf()
